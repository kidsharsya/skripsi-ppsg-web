<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\CatatanKeuangan;

class CatatanIuran extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','rt','tanggal_pertemuan'];

    public function anggota(): BelongsToMany
    {
        return $this->belongsToMany(Anggota::class)->withPivot('status_bayar')->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($catatanIuran) {
            // Find and delete related CatatanKeuangan
            CatatanKeuangan::where('deskripsi', 'LIKE', 'Iuran Kas RT ' . $catatanIuran->rt . ' - ' . \Carbon\Carbon::parse($catatanIuran->tanggal_pertemuan)->format('d/m/Y'))
                ->delete();
        });
    }
}
