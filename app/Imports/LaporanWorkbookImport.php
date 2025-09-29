<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanWorkbookImport implements WithMultipleSheets
{
    public int $successCount = 0;
    public int $duplicateCount = 0;
    public int $skipCount = 0;
    public int $errorCount = 0;

    public array $processedSheets = [];

    public function __construct(public $user) {}

    public function sheets(): array
    {
        $h = new \App\Imports\LaporanSheetImport($this);

        // Proses 12 sheet pertama (index 0..11)
        return [
            0 => $h, 1 => $h, 2 => $h, 3 => $h,
            4 => $h, 5 => $h, 6 => $h, 7 => $h,
            8 => $h, 9 => $h, 10 => $h, 11 => $h,
        ];
    }
}
