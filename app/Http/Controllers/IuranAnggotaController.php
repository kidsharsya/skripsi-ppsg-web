<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Anggota;
use App\Models\CatatanIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IuranAnggotaController extends Controller
{
    public function riwayat()
    {
        // Ambil anggota berdasarkan user yang login
        $anggota = Anggota::where('user_id', Auth::id())->first();

        if (!$anggota) {
            abort(404, 'Data anggota tidak ditemukan');
        }

        // Ambil semua catatan iuran
        $catatanIurans = CatatanIuran::with('anggota')
        ->where('rt', $anggota->rt)
        ->orderBy('tanggal_pertemuan', 'desc')
        ->get();

        // Siapkan data status bayar
        $riwayat = $catatanIurans->map(function ($item) use ($anggota) {
        $sudahBayar = $item->anggota
            ->where('id', $anggota->id)
            ->first()
                ?->pivot
                ?->status_bayar ?? false;


            return [
                'id' => $item->id,
                'tanggal_pertemuan' => $item->tanggal_pertemuan,
                'rt' => $item->rt,
                'status' => $sudahBayar ? 'Sudah Bayar' : 'Belum Bayar',
            ];
        });

        return Inertia::render('RiwayatIuran', [
            'riwayat' => $riwayat,
        ]);
    }
}
