<?php
// app/Imports/LaporanSheetImport.php
namespace App\Imports;

use App\Models\Anak;
use App\Models\LaporanAnak;
use App\Models\LaporanBulananPosyandu;
use App\Models\TbStuntingStandar;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class LaporanSheetImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsOnFailure, SkipsOnError, WithEvents
{
    use SkipsFailures;

    public function __construct(private LaporanWorkbookImport $root) {}

    public function chunkSize(): int { return 1000; }

    public function onError(\Throwable $e) { $this->root->errorCount++; }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->root->processedSheets[] = $event->getSheet()->getTitle();
            },
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $this->processRow($row);
            } catch (\Throwable $e) {
                $this->root->errorCount++;
            }
        }
    }

    private function processRow($row): void
    {
        $r = collect($row)->mapWithKeys(function ($v, $k) {
            return [strtolower(trim($k)) => is_string($v) ? trim($v) : $v];
        });

        // --- Identifikasi Anak ---
        $anak = null;
        if ($r->get('anak_id')) {
            $anak = Anak::find((int) $r->get('anak_id'));
        } elseif ($r->get('nik_anak')) {
            $anak = Anak::where('nik', (string) $r->get('nik_anak'))->first();
        }
        if (!$anak) { $this->root->skipCount++; return; }

        // --- Guard Posyandu (kader hanya posyandu-nya) ---
        $kaderPosId = $this->root->user->posyandu_id ?? null;
        if ($kaderPosId && (int)$anak->posyandu_id !== (int)$kaderPosId) {
            // NOTE: jika file-mu untuk posyandu lain, semua baris akan diskip!
            $this->root->skipCount++; return;
        }

        // --- Tanggal Pemeriksaan (dukung serial & berbagai format umum) ---
        $tgl = $this->parseDate($r->get('tanggal_pemeriksaan'));
        if (!$tgl || $tgl->gt(now())) { $this->root->skipCount++; return; }

        // --- Cek duplikat per anak x bulan ---
        $start = $tgl->copy()->startOfMonth();
        $end   = $tgl->copy()->endOfMonth();

        $dup = LaporanAnak::where('anak_id', $anak->id)
            ->whereBetween('tanggal_pemeriksaan', [$start, $end])
            ->exists();
        if ($dup) { $this->root->duplicateCount++; return; }

        // --- Nilai ---
        $bb   = $this->toFloat($r->get('berat_badan'));
        $tb   = $this->toFloat($r->get('tinggi_badan'));
        $lk   = $this->toFloat($r->get('lingkar_kepala'));
        $lila = $this->toFloat($r->get('lingkar_lengan_atas'));
        if ($bb===null || $tb===null || $lk===null || $lila===null) { $this->root->skipCount++; return; }

        // --- Status stunting (umur pada hari-H) ---
        $umurBulan = Carbon::parse($anak->tanggal_lahir)->diffInMonths($tgl);
        $std = TbStuntingStandar::where('jenis_kelamin', $anak->kelamin)
            ->where('umur_bulan', $umurBulan)
            ->first();
        $status = ($std && $tb < $std->sd_min_1) ? 'Stunting' : 'Normal';

        // --- Simpan ---
        LaporanAnak::create([
            'anak_id' => $anak->id,
            'tanggal_pemeriksaan' => $tgl->toDateString(),
            'berat_badan' => $bb,
            'tinggi_badan' => $tb,
            'lingkar_kepala' => $lk,
            'lingkar_lengan_atas' => $lila,
            'status' => $status,
        ]);

        // --- Rekap bulanan posyandu ---
        LaporanBulananPosyandu::updateOrCreate(
            [
                'posyandu_id' => $anak->posyandu_id,
                'tanggal_laporan' => $start->toDateString(),
            ],
            ['status' => 'sudah']
        );

        $this->root->successCount++;
    }

    private function parseDate($value): ?Carbon
    {
        if ($value === null || $value === '') return null;

        try {
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->startOfDay();
            }
            $s = trim((string) $value);

            // Coba format-format populer lebih dulu
            foreach (['Y-m-d','d/m/Y','d-m-Y','m/d/Y'] as $fmt) {
                $dt = Carbon::createFromFormat($fmt, $s);
                if ($dt !== false) return $dt->startOfDay();
            }

            // Fallback parser bawaan Carbon/strtotime
            return Carbon::parse($s)->startOfDay();
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function toFloat($v): ?float
    {
        if ($v === null || $v === '') return null;
        if (is_numeric($v)) return (float) $v;
        $v = str_replace([' ', ','], ['', '.'], (string) $v);
        return is_numeric($v) ? (float) $v : null;
    }
}
