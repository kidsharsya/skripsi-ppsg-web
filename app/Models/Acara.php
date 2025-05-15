<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'latitude',
        'longitude',
        'token',
    ];

    public function presensis()
    {
    return $this->hasMany(Presensi::class);
    }

    protected static function booted()
    {
    static::creating(function ($acara) {
        $acara->token = strtoupper(str()->random(6)); // Contoh token: F3J8XZ
    });

    // Setelah acara dibuat, buat data presensi otomatis
    static::created(function ($acara) {
        $anggotaAktif = Anggota::whereIn('status_keanggotaan', ['aktif', 'pasif'])->get();

        foreach ($anggotaAktif as $anggota) {
            Presensi::create([
                'acara_id' => $acara->id,
                'anggota_id' => $anggota->id,
                'status' => 'Tidak Hadir',
            ]);
        }
    });
    }


}
