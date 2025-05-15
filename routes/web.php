<?php

use Inertia\Inertia;
use App\Models\Acara;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\ArsipRapatController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\PresensiController;
use App\Http\Controllers\IuranAnggotaController;
use App\Http\Controllers\ArsipProgramKerjaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function (){
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('/riwayat-iuran', [IuranAnggotaController::class, 'riwayat']);
    Route::get('/presensi', [PresensiController::class, 'riwayatPresensi'])->name('presensi.index');
    Route::get('/presensi/{acara}', function (Acara $acara) {
        return Inertia::render('PresensiForm', [
            'acara' => $acara,
        ]);
    })->name('presensi.form');
    Route::get('/presensi/{acara}/izin', function (Acara $acara) {
        return Inertia::render('IzinPresensiForm', [
            'acara' => $acara,
        ]);
    })->name('presensi.form');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/arsip-rapat', [ArsipRapatController::class, 'index'])->name('arsip.index');
    Route::get('/arsip-rapat/{id}', [ArsipRapatController::class, 'show'])->name('arsip.show');
    Route::get('/arsip-program-kerja', [ArsipProgramKerjaController::class, 'index'])->name('arsip.index');
    Route::get('/profile', [AnggotaController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [AnggotaController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [AnggotaController::class, 'updateProfil'])->name('profile.update');
}); #Ini route middleware untuk halaman pengguna

Route::get('/export-pdf', [AnggotaController::class, 'exportPdf'])->name('anggota.exportPdf');

