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

class LaporanSheetImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    SkipsOnFailure,
    SkipsOnError,
    WithEvents
{
    use SkipsFailures;

    public function __construct(private LaporanWorkbookImport $root) {}

    // supaya tidak berat saat file besar
    public function chunkSize(): int
    {
        return 1000;
    }

    // kalau ada error yang tidak tertangkap per baris
    public function onError(\Throwable $e)
    {
        $this->root->errorCount++;
    }

    // simpan nama sheet yang diproses, berguna kalau mau ditampilkan
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->root->processedSheets[] = $event->getSheet()->getTitle();
            },
        ];
    }

    // dipanggil per-chunk
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $this->processRow($row);
            } catch (\Throwable $e) {
                // jika ada error tak terduga di baris ini
                $this->root->errorCount++;
            }
        }
    }

    /**
     * Proses satu baris data laporan
     */
    private function processRow($row): void
    {
        // normalisasi key: huruf kecil semua + trim spasi
        $r = collect($row)->mapWithKeys(function ($v, $k) {
            return [strtolower(trim($k)) => is_string($v) ? trim($v) : $v];
        });

        /*
         |-----------------------------
         | 1. Identifikasi anak
         |-----------------------------
         | Bisa pakai:
         | - anak_id    (jika ada)
         | - nik_anak   (paling umum)
         */
        $anak = null;

        if ($r->get('anak_id')) {
            $anak = Anak::find((int) $r->get('anak_id'));
        } elseif ($r->get('nik_anak')) {
            $anak = Anak::where('nik', (string) $r->get('nik_anak'))->first();
        }

        if (!$anak) {
            // data anak tidak ditemukan → dilewati
            $this->root->skipCount++;
            return;
        }

        /*
         | 2. Batasi hanya untuk posyandu milik kader login
         */
        $kaderPosId = $this->root->user->posyandu_id ?? null;

        if ($kaderPosId && (int) $anak->posyandu_id !== (int) $kaderPosId) {
            // kalau file untuk posyandu lain, otomatis dilewati
            $this->root->skipCount++;
            return;
        }

        /*
         | 3. Tanggal pemeriksaan
         |    - dukung serial Excel (angka)
         |    - dukung beberapa format populer (10/01/2025, 2025-01-10, dll)
         |    - tidak boleh di masa depan
         */
        $tgl = $this->parseDate($r->get('tanggal_pemeriksaan'));

        if (!$tgl || $tgl->gt(now())) {
            $this->root->skipCount++;
            return;
        }

        /*
         | 4. Cek duplikat:
         |    satu anak hanya boleh punya satu laporan per bulan.
         */
        $start = $tgl->copy()->startOfMonth();
        $end   = $tgl->copy()->endOfMonth();

        $dup = LaporanAnak::where('anak_id', $anak->id)
            ->whereBetween('tanggal_pemeriksaan', [$start->toDateString(), $end->toDateString()])
            ->exists();

        if ($dup) {
            $this->root->duplicateCount++;
            return;
        }

        /*
         | 5. Ambil nilai pengukuran
         */
        $bb   = $this->toFloat($r->get('berat_badan'));
        $tb   = $this->toFloat($r->get('tinggi_badan'));
        $lk   = $this->toFloat($r->get('lingkar_kepala'));
        $lila = $this->toFloat($r->get('lingkar_lengan_atas'));

        // jika ada yang kosong / tidak valid → lewati
        if ($bb === null || $tb === null || $lk === null || $lila === null) {
            $this->root->skipCount++;
            return;
        }

        /*
         | 6. Hitung status stunting
         */
        $umurBulan = Carbon::parse($anak->tanggal_lahir)->diffInMonths($tgl);

        $std = TbStuntingStandar::where('jenis_kelamin', $anak->kelamin)
            ->where('umur_bulan', $umurBulan)
            ->first();

        $status = ($std && $tb < $std->sd_min_1) ? 'Stunting' : 'Normal';

        /*
         | 7. Simpan laporan anak
         */
        LaporanAnak::create([
            'anak_id'             => $anak->id,
            'tanggal_pemeriksaan' => $tgl->toDateString(),
            'berat_badan'         => $bb,
            'tinggi_badan'        => $tb,
            'lingkar_kepala'      => $lk,
            'lingkar_lengan_atas' => $lila,
            'status'              => $status,
        ]);

        /*
         | 8. Update rekap bulanan posyandu
         */
        LaporanBulananPosyandu::updateOrCreate(
            [
                'posyandu_id'     => $anak->posyandu_id,
                'tanggal_laporan' => $start->toDateString(),
            ],
            [
                'status' => 'sudah',
            ]
        );

        $this->root->successCount++;
    }

    /**
     * Parse berbagai kemungkinan format tanggal + serial Excel.
     */
    private function parseDate($value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            // format angka (serial date Excel)
            if (is_numeric($value)) {
                return Carbon::instance(
                    ExcelDate::excelToDateTimeObject($value)
                )->startOfDay();
            }

            $s = trim((string) $value);

            // coba beberapa format umum dulu
            foreach (['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'] as $fmt) {
                $dt = Carbon::createFromFormat($fmt, $s);
                if ($dt !== false) {
                    return $dt->startOfDay();
                }
            }

            // fallback: parser bawaan Carbon (lebih longgar)
            return Carbon::parse($s)->startOfDay();

        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Konversi ke float, dukung koma/ titik.
     */
    private function toFloat($v): ?float
    {
        if ($v === null || $v === '') {
            return null;
        }

        if (is_numeric($v)) {
            return (float) $v;
        }

        // ganti koma jadi titik dan hapus spasi
        $v = str_replace([' ', ','], ['', '.'], (string) $v);

        return is_numeric($v) ? (float) $v : null;
    }
}
