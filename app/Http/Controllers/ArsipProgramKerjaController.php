<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Arsip;
use Illuminate\Http\Request;

class ArsipProgramKerjaController extends Controller
{
    public function index()
{
    $arsipProgramKerja = Arsip::orderBy('tanggal_kegiatan', 'desc')->get();

    return Inertia::render('ArsipProgramKerja', [
        'arsipProgramKerja' => $arsipProgramKerja,
    ]);
}

}
