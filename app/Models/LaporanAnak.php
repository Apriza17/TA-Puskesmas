<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanAnak extends Model
{
    use HasFactory;

    protected $table = 'laporan_anak_bulanan';

    protected $fillable = [
        'anak_id', 'tanggal_pemeriksaan', 'berat_badan',
        'tinggi_badan', 'lingkar_kepala', 'lingkar_lengan_atas', 'status'
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }
}
