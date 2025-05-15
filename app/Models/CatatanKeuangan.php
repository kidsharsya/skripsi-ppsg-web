<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatatanKeuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'deskripsi',
        'masuk',
        'keluar',
        'user_id',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
