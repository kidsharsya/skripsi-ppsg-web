<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CatatanKeuangan;

class KeuanganController extends Controller
{
    public function index()
    {
        $catatan = CatatanKeuangan::select('id', 'tanggal', 'deskripsi', 'masuk', 'keluar')
            // ->orderByDesc('tanggal')
            ->get();
            $totalMasuk = $catatan->sum('masuk');
            $totalKeluar = $catatan->sum('keluar');
            $saldoAkhir = $totalMasuk - $totalKeluar;

        return Inertia::render('Keuangan', [
            'catatan' => $catatan,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo_akhir' => $saldoAkhir,
        ]);
    }
}
