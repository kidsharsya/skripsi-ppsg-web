<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'banner_image',
        'deskripsi',
        'visi',
        'misi',
        'section1',
        'section2',
        'section3',
        'section4',
        'section5',
        'section6',
    ];    

    protected $casts = [
        'misi' => 'array',
    ];
}
