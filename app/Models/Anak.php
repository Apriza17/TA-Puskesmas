<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Anak extends Model
{
    use HasFactory;
    protected $table = 'anak';
    protected $fillable = ['posyandu_id', 'nama', 'kelamin', 'nik', 'tanggal_lahir', 'berat_lahir', 'tinggi_lahir'];

    public function getIsKkAttribute()
    {
        // 1. Ambil data tanggal lahir & kelamin
        if (!$this->tanggal_lahir || !$this->nik) {
            return false; // Anggap bukan KK kalau data tidak lengkap
        }

        $tglLahir = Carbon::parse($this->tanggal_lahir);

        // 2. Format Tanggal Lahir sesuai rumus NIK
        // Rumus: ddmmyy (Tapi kalau perempuan, tanggal + 40)
        $hari = $tglLahir->format('d');
        $bulanTahun = $tglLahir->format('my'); // mmYY

        if ($this->kelamin === 'P') {
            $hari += 40; // Perempuan tanggalnya ditambah 40
        }

        // Pastikan hari 2 digit (misal: 1 jadi 01)
        $kodeTglLahir = str_pad($hari, 2, '0', STR_PAD_LEFT) . $bulanTahun;

        // 3. Cek apakah kode tgl lahir ada di dalam NIK (digit ke-7 sampai 12)
        // substr(string, start, length). Di database string mulai index 0.
        // Digit ke-7 berarti index ke-6.
        $bagianTglDiNik = substr($this->nik, 6, 6);

        // 4. Jika SAMA persis, berarti NIK. Jika BEDA, berarti KK.
        // Return true jika ini ADALAH KK (karena tidak sama)
        return $bagianTglDiNik !== $kodeTglLahir;
    }


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
