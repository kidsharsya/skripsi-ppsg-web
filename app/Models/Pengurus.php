<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengurus extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'is_pengurus_utama',
    ]; 

    public function getFotoUrlAttribute()
    {
        return $this->foto
            ? Storage::disk('public')->url($this->foto)
            : null;
    }
}
