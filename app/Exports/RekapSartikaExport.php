<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapSartikaExport implements FromView, ShouldAutoSize
{
    public function __construct(
        public $rows,
        public $tanggal,
        public $rataRata
    ) {}

    public function view(): View
    {
        return view('exports.rekap_sartika', [
            'rows'     => $this->rows,      // TIDAK dipaginate
            'tanggal'  => $this->tanggal,   // Carbon
            'rataRata' => $this->rataRata,
        ]);
    }
}
