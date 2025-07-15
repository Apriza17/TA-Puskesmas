<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;
    protected $fillable = [
        'posyandu_id',
        'judul',
        'isi',
        'terbaca',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }
}
