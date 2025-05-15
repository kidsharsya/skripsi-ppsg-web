<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'acara_id',
        'anggota_id',
        'waktu_presensi',
        'status',
        'alasan',
        'latitude',
        'longitude',
    ];    

    public function acara()
    {
    return $this->belongsTo(Acara::class);
    }

    public function anggota()
    {
    return $this->belongsTo(Anggota::class);
    }

}
