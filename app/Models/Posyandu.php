<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posyandu extends Model
{
    use HasFactory;
    protected $table = 'posyandu';
    protected $fillable = ['nama'];

    public function kader(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function anak()
    {
        return $this->hasMany(Anak::class, 'posyandu_id');
    }

    public function bumil()
    {
        return $this->hasMany(Bumil::class, 'posyandu_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'posyandu_id');
    }

    public function pesan()
    {
        return $this->hasMany(Pesan::class);
    }
}
