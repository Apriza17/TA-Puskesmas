<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanWorkbookImport implements WithMultipleSheets
{
    // counter hasil import
    public int $successCount   = 0;
    public int $duplicateCount = 0;
    public int $skipCount      = 0;
    public int $errorCount     = 0;

    // untuk debugging: nama sheet yang sempat diproses
    public array $processedSheets = [];

    public function __construct(public $user) {}

    public function sheets(): array
    {
        // satu handler untuk semua sheet
        $handler = new LaporanSheetImport($this);

        // Januari–November
        return [
            1  => $handler, // Januari
            2  => $handler, 
            3  => $handler,
            4  => $handler,
            5  => $handler,
            6  => $handler,
            7  => $handler,
            8  => $handler,
            9  => $handler,
            10 => $handler,
            11 => $handler,
            12 => $handler, // Desember
        ];
    }
}
