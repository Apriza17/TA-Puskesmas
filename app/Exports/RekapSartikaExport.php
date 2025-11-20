<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;     // Untuk styling manual
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapSartikaExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct(
        public $rows,
        public $tanggal,
        public $rataRata
    )
    {}

   public function view(): View
    {
        return view('exports.rekap_sartika', [
            'rows'     => $this->rows,      // TIDAK dipaginate
            'tanggal'  => $this->tanggal,   // Carbon
            'rataRata' => $this->rataRata,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Hitung baris terakhir data
        $highestRow = $sheet->getHighestRow();

        return [
            // 1. Styling Judul (Baris 1)
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],

            // 2. Styling Header Tabel (Baris 3 dan 4 - karena ada baris kosong di row 2)
            // Sesuaikan range 'A3:J4' dengan posisi tabelmu di Excel
            'A4:J5' => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'], // Warna Teks Putih
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF0284C7'], // Warna Background Biru (mirip sky-600)
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            // 3. Styling Seluruh Tabel (Border & Alignment Tengah untuk Angka)
            'A4:J' . $highestRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            // 4. Alignment Khusus Kolom (Bikin Rata Tengah untuk Angka)
            // Kolom A (No), C sampai J (Angka-angka)
            'A3:A' . $highestRow => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'C3:J' . $highestRow => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],

            // Kolom B (Nama Posyandu) biarkan rata kiri (default) atau set explicit left
            'B3:B' . $highestRow => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],

            // 5. Styling Footer (Rata-rata) - Baris Terakhir
            'A' . $highestRow . ':J' . $highestRow => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFEEEEEE'], // Abu-abu muda
                ],
            ],
        ];
    }

}
