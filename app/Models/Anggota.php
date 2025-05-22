<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama', 'tempat_tgl_lahir', 'jenis_kelamin', 'agama', 'rt', 'gol_darah', 'no_hp', 'status_keanggotaan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function catatanIuran(): BelongsToMany
    {
    return $this->belongsToMany(CatatanIuran::class, 'anggota_catatan_iuran')->withPivot('status_bayar')->withTimestamps();
    }

    public function presensis()
    {
    return $this->hasMany(Presensi::class);
    }




}
