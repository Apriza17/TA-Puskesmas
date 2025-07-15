<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory;
    protected $table = 'anak';
    protected $fillable = ['posyandu_id', 'nama', 'kelamin', 'nik', 'tanggal_lahir', 'berat_lahir', 'tinggi_lahir'];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }

    public function LaporanBulanan()
    {
        return $this->hasMany(LaporanAnak::class);
    }

    public function laporanAnak()
    {
        return $this->hasMany(LaporanAnak::class, 'anak_id');
    }
}
