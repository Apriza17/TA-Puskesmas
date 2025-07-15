<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbStuntingStandar extends Model
{
    use HasFactory;
    protected $table = 'tb_stunting_standar';

    protected $fillable = [
        'jenis_kelamin',
        'umur_bulan',
        'sd_min_3',
        'sd_min_2',
        'sd_min_1',
        'median',
        'sd_plus_1',
        'sd_plus_2',
        'sd_plus_3',
    ];
}
