<?php

namespace App\Imports;

use App\Models\TbStuntingStandar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StuntingStandarImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new TbStuntingStandar([
            'jenis_kelamin' => $row['jenis_kelamin'],
            'umur_bulan'    => $row['umur_bulan'],
            'sd_min_3'      => $row['sd_min_3'],
            'sd_min_2'      => $row['sd_min_2'],
            'sd_min_1'      => $row['sd_min_1'],
            'median'        => $row['median'],
            'sd_plus_1'     => $row['sd_plus_1'],
            'sd_plus_2'     => $row['sd_plus_2'],
            'sd_plus_3'     => $row['sd_plus_3'],
        ]);
    }
}

