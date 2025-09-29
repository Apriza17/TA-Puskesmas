<?php
// app/Imports/LaporanBulanImport.php
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
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class LaporanBulanImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsOnFailure, SkipsOnError
{
    use SkipsFailures;

    public int $successCount = 0;
    public int $duplicateCount = 0;
    public int $skipCount = 0;
    public int $errorCount = 0;

    public function __construct(
        public $user,
        public Carbon $bulanDipilih, // awal bulan
    ) {}

    public function chunkSize(): int { return 1000; }

    public function onError(\Throwable $e) { $this->errorCount++; }

    public function collection(Collection $rows)
    {
        $awal = $this->bulanDipilih->copy()->startOfMonth();
        $akhir= $this->bulanDipilih->copy()->endOfMonth();
        $posyanduIdKader = $this->user->posyandu_id ?? null;

        foreach ($rows as $row) {
            try {
                $r = collect($row)->mapWithKeys(function($v, $k){
                    return [strtolower(trim($k)) => is_string($v) ? trim($v) : $v];
                });

                // --- Anak: by anak_id atau nik_anak
                $anak = null;
                if ($r->get('anak_id')) {
                    $anak = Anak::find((int) $r->get('anak_id'));
                } elseif ($r->get('nik_anak')) {
                    $anak = Anak::where('nik', (string) $r->get('nik_anak'))->first();
                }
                if (!$anak) { $this->skipCount++; continue; }

                // hanya untuk posyandu kader
                if ($posyanduIdKader && (int)$anak->posyandu_id !== (int)$posyanduIdKader) {
                    $this->skipCount++; continue;
                }

                // --- tanggal pemeriksaan
                $tgl = $this->parseDate($r->get('tanggal_pemeriksaan'));
                if (!$tgl) { $this->skipCount++; continue; }

                // pastikan berada di bulan yang dipilih
                if ($tgl->lt($awal) || $tgl->gt($akhir)) {
                    $this->skipCount++; continue;
                }

                // --- hindari duplikat anak × bulan
                $dup = LaporanAnak::where('anak_id', $anak->id)
                        ->whereBetween('tanggal_pemeriksaan', [$awal, $akhir])
                        ->exists();
                if ($dup) { $this->duplicateCount++; continue; }

                // --- nilai
                $bb   = $this->toFloat($r->get('berat_badan'));
                $tb   = $this->toFloat($r->get('tinggi_badan'));
                $lk   = $this->toFloat($r->get('lingkar_kepala'));
                $lila = $this->toFloat($r->get('lingkar_lengan_atas'));
                if ($bb===null || $tb===null || $lk===null || $lila===null) { $this->skipCount++; continue; }

                // --- status stunting (umur pada hari H)
                $umurBulan = Carbon::parse($anak->tanggal_lahir)->diffInMonths($tgl);
                $std = TbStuntingStandar::where('jenis_kelamin', $anak->kelamin)
                        ->where('umur_bulan', $umurBulan)
                        ->first();
                $status = ($std && $tb < $std->sd_min_1) ? 'Stunting' : 'Normal';

                // --- simpan
                LaporanAnak::create([
                    'anak_id' => $anak->id,
                    'tanggal_pemeriksaan' => $tgl->toDateString(),
                    'berat_badan' => $bb,
                    'tinggi_badan' => $tb,
                    'lingkar_kepala' => $lk,
                    'lingkar_lengan_atas' => $lila,
                    'status' => $status,
                ]);

                // --- rekap bulanan posyandu
                LaporanBulananPosyandu::updateOrCreate(
                    [
                        'posyandu_id' => $anak->posyandu_id,
                        'tanggal_laporan' => $awal->toDateString(),
                    ],
                    ['status' => 'sudah']
                );

                $this->successCount++;
            } catch (\Throwable $e) {
                $this->errorCount++;
            }
        }
    }

    private function parseDate($value): ?Carbon
    {
        if ($value === null || $value === '') return null;
        try {
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->startOfDay();
            }
            $s = trim((string)$value);
            foreach (['Y-m-d','d/m/Y','d-m-Y','m/d/Y'] as $fmt) {
                $dt = Carbon::createFromFormat($fmt, $s);
                if ($dt !== false) return $dt->startOfDay();
            }
            return Carbon::parse($s)->startOfDay();
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function toFloat($v): ?float
    {
        if ($v === null || $v === '') return null;
        if (is_numeric($v)) return (float)$v;
        $v = str_replace([' ', ','], ['', '.'], (string)$v);
        return is_numeric($v) ? (float)$v : null;
        }
}

