<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan', 'tanggal_kegiatan', 'proposal', 'lpj', 'dokumentasi', 'dokumen_lain'
    ];
}
