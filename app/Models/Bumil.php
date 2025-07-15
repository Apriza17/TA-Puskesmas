<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bumil extends Model
{
    use HasFactory;
    protected $table = 'bumil';
    protected $fillable = ['posyandu_id', 'nama', 'nik', 'tanggal_lahir'];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }
}
