<?php

namespace App\Imports;

use App\Models\Posyandu;
use App\Models\Anak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AnakPosyanduImport implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    // HAPUS: use SkipsErrors, SkipsFailures;

    public function rules(): array
    {
        return [
            'posyandu_nama' => ['required', 'string', 'max:255'],
            'nik'           => ['nullable', 'numeric', 'digits:16'],
            'nama'          => ['required', 'string', 'max:255'],
            'kelamin'       => ['required', 'string', 'in:L,P,l,p,LAKI-LAKI,PEREMPUAN'],
            'tanggal_lahir' => ['required',
            function ($attribute, $value, $fail) {
                // gunakan helper parseDate() yang sudah kamu buat
                if ($this->parseDate($value) === null) {
                    $fail('Format ' . $attribute . ' tidak valid. Gunakan tanggal yang benar (misal 08/10/2024) atau tanggal Excel.');
                }
            },
        ],
            'berat_lahir'   => ['nullable', 'numeric'],
            'tinggi_lahir'  => ['nullable', 'numeric'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'posyandu_nama.required' => 'Nama Posyandu wajib diisi.',
            'nama.required'          => 'Nama anak wajib diisi.',
            'nik.digits'             => 'NIK harus 16 digit angka.',
            'nik.numeric'            => 'NIK harus berupa angka.',
            'kelamin.required'       => 'Jenis kelamin wajib diisi.',
            'kelamin.in'             => 'Jenis kelamin harus L atau P.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        ];
    }

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
