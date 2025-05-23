<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ArsipRapat;
use Illuminate\Http\Request;

class ArsipRapatController extends Controller
{
    // Menampilkan semua arsip rapat
    public function index()
    {
        $arsipRapat = ArsipRapat::orderBy('tanggal_rapat', 'desc')->get();

        return Inertia::render('ArsipRapat', [
            'arsipRapat' => $arsipRapat,
        ]);
    }

    // Menampilkan detail arsip rapat berdasarkan ID
    public function show($id)
    {
        $arsip = ArsipRapat::findOrFail($id);

        return Inertia::render('ArsipRapatDetail', [
            'arsip' => [
                'id' => $arsip->id,
                'judul_rapat' => $arsip->judul_rapat,
                'tanggal_rapat' => $arsip->tanggal_rapat,
                'notulensi' => $arsip->notulensi,
                'dokumentasi' => $arsip->dokumentasi_url,
            ]
        ]);
    }
}
