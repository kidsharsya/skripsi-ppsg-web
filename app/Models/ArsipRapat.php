<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipRapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_rapat',
        'tanggal_rapat',
        'notulensi',
        'dokumentasi',
    ];

    public function getDokumentasiUrlAttribute()
    {
        return $this->dokumentasi ? asset('storage/' . $this->dokumentasi) : null;
    }
}
