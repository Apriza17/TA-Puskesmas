<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanBulananPosyandu extends Model
{
    use HasFactory;

    protected $table = 'laporan_bulanan_posyandu';

    protected $fillable = ['posyandu_id', 'tanggal_laporan', 'status'];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }
}
