<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CatatanKeuangan;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function exportPdf()
    {
    $catatan = CatatanKeuangan::select('tanggal', 'deskripsi', 'masuk', 'keluar')->get();
    $totalMasuk = $catatan->sum('masuk');
    $totalKeluar = $catatan->sum('keluar');
    $saldoAkhir = $totalMasuk - $totalKeluar;

    $pdf = Pdf::loadView('laporan-keuangan', compact('catatan', 'totalMasuk', 'totalKeluar', 'saldoAkhir'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('laporan-keuangan.pdf');
    }
}
