<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::all(); // Mengambil semua data anggota

        // Hitung jumlah berdasarkan RT
        $jumlahRt = Anggota::selectRaw('rt, COUNT(*) as total')->groupBy('rt')->pluck('total', 'rt');

        // Hitung jumlah berdasarkan jenis kelamin
        $jumlahGender = Anggota::selectRaw('jenis_kelamin, COUNT(*) as total')->groupBy('jenis_kelamin')->pluck('total', 'jenis_kelamin');

        return Inertia::render('Anggota', [
            'anggotas' => $anggotas,
            'jumlahRt' => $jumlahRt,
            'jumlahGender' => $jumlahGender,
        ]);
    }

    public function profil()
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return response()->json(['message' => 'Data anggota tidak ditemukan.'], 404);
        }

        return response()->json([
            'anggota' => $anggota,
        ]);
    }

    public function showProfile()
    {
    $anggota = Auth::user()->anggota;

    return Inertia::render('Profile', [
        'anggota' => $anggota,
    ]);
    }

    public function editProfile()
    {
    $anggota = Auth::user()->anggota;

    return Inertia::render('ProfileEdit', [
        'anggota' => $anggota,
    ]);
    }


    // Mengupdate data profil anggota yang login
    public function updateProfil(Request $request)
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'tempat_tgl_lahir' => 'nullable|string|max:255',
        'jenis_kelamin' => 'nullable|string|max:10',
        'agama' => 'nullable|string|max:50',
        'rt' => 'nullable|string|max:10',
        'gol_darah' => 'nullable|string|max:5',
        'no_hp' => 'nullable|string|max:20',
    ]);

    $anggota = Auth::user()->anggota;

    if ($anggota) {
        $anggota->update($request->only([
            'nama',
            'tempat_tgl_lahir',
            'jenis_kelamin',
            'agama',
            'rt',
            'gol_darah',
            'no_hp',
        ]));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
    }


}
