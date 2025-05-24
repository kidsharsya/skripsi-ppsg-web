<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Arsip;
use App\Models\Galeri;
use App\Models\Anggota;
use App\Models\Pengurus;
use App\Models\Testimoni;
use App\Models\ArsipRapat;
use App\Models\HomeContent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil data HomeContent (hanya akan ada 1 record berdasarkan implementasi canCreate())
        $homeContent = HomeContent::first() ?? new HomeContent();
        
        $homeContent->banner_image_url = $homeContent->banner_image_url;

        $stats = [
            'anggotaAktif' => Anggota::where('status_keanggotaan', 'aktif')->count(),
            'programKerja' => Arsip::count(),
            'rapatTerlaksana' => ArsipRapat::count(),
            'rtTerlibat' => Anggota::distinct('rt')->count('rt'),
        ];

        // Ambil data pengurus
        $pengurus = Pengurus::all();
        // Ambil data galeri dokumentasi
        $galeri = Galeri::all()->map(function ($item) {
            $item->image_url = $item->image_url;
            return $item;
        });

        

        // Render halaman Home dengan data yang diperlukan
        return Inertia::render('Home', [
            'homeContent' => $homeContent,
            'stats' => $stats,
            'pengurus' => $pengurus,
            'galeri' => $galeri,
        ]);
    }
}
