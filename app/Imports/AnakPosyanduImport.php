<?php

namespace App\Imports;

use App\Models\Posyandu;
use App\Models\Anak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AnakPosyanduImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    public int $created = 0;
    public int $updated = 0;

    /** cache posyandu by nama */
    protected array $pCache = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $pn   = $this->normalizePosyandu($row['posyandu_nama'] ?? null);
            $nik  = $this->normalizeNik($row['nik'] ?? null);
            $nama = $this->cleanName($row['nama'] ?? null);
            $jk   = $this->normalizeJK($row['kelamin'] ?? null);
            $tgl  = $this->parseDate($row['tanggal_lahir'] ?? null);

            if (!$pn || !$nama || !$jk || !$tgl) {
                // Lewati baris yang tidak valid minimal
                continue;
            }

            $posyandu = $this->getPosyandu($pn);

            $payload = [
                'posyandu_id'   => $posyandu->id,
                'nama'          => $nama,
                'kelamin'       => $jk,
                'tanggal_lahir' => $tgl,
                'berat_lahir'   => $this->toFloat($row['berat_lahir'] ?? null),
                'tinggi_lahir'  => $this->toFloat($row['tinggi_lahir'] ?? null),
            ];

            if ($nik) {
                $existing = Anak::where('nik', $nik)->first();
                if ($existing) { $existing->update($payload); $this->updated++; }
                else { $payload['nik'] = $nik; Anak::create($payload); $this->created++; }
            } else {
                // fallback: kombinasi (nama + tgl + posyandu)
                $existing = Anak::where('posyandu_id', $posyandu->id)
                    ->where('nama', $nama)
                    ->whereDate('tanggal_lahir', $tgl)
                    ->first();

                if ($existing) { $existing->update($payload); $this->updated++; }
                else { Anak::create($payload); $this->created++; }
            }
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }

    protected function getPosyandu(string $nama): Posyandu
    {
        if (isset($this->pCache[$nama])) return $this->pCache[$nama];

        $p = Posyandu::firstOrCreate(['nama' => $nama]);
        $this->pCache[$nama] = $p;
        return $p;
    }

    protected function normalizePosyandu($v): ?string
    {
        $v = is_null($v) ? null : trim((string)$v);
        return $v === '' ? null : preg_replace('/\s+/', ' ', $v);
    }

    protected function cleanName($v): ?string
    {
        $v = is_null($v) ? null : trim((string)$v);
        return $v === '' ? null : preg_replace('/\s+/', ' ', $v);
    }

    protected function normalizeJK($v): ?string
    {
        $v = strtoupper(trim((string)$v));
        if ($v === '') return null;
        $f = mb_substr($v, 0, 1);
        return in_array($f, ['L','P']) ? $f : null;
    }

    protected function normalizeNik($v): ?string
    {
        if ($v === null) return null;
        $v = preg_replace('/\D/', '', (string)$v);
        return $v === '' ? null : $v;
    }

    protected function parseDate($v): ?\Carbon\Carbon
    {
        if ($v === null || $v === '') return null;

        if (is_numeric($v)) {
            try {
                return \Carbon\Carbon::instance(ExcelDate::excelToDateTimeObject($v));
            } catch (\Throwable $e) {
                return null;
            }
        }
        try {
            return \Carbon\Carbon::parse($v);
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function toFloat($v): ?float
    {
        if ($v === null || $v === '') return null;
        return (float) str_replace(',', '.', (string)$v);
    }
}
