<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapPresensiController extends Controller
{
    public function export()
    {
        $anggota = Anggota::withCount([
            'presensis as hadir_count' => fn ($q) => $q->where('status', 'Hadir'),
            'presensis as izin_count' => fn ($q) => $q->where('status', 'Izin'),
            'presensis as tidak_hadir_count' => fn ($q) => $q->where('status', 'Tidak Hadir'),
            'presensis as total_kegiatan'
        ])->get();

        $pdf = Pdf::loadView('rekap-presensi', compact('anggota'));

        return $pdf->download('rekap-presensi.pdf');
    }
}
