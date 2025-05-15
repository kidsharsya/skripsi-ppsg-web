<?php

namespace App\Filament\Resources\CatatanKeuanganResource\Pages;

use App\Models\CatatanKeuangan;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\CatatanKeuanganResource;

class LaporanKeuangan extends Page
{
    protected static string $resource = CatatanKeuanganResource::class;

    protected static string $view = 'filament.resources.catatan-keuangan-resource.pages.laporan-keuangan';

    public $laporanKeuangan; // Data untuk laporan keuangan per periode
    public $totalPemasukan;
    public $totalPengeluaran;
    public $saldoAkhir;

    public function mount()
    {
        // Menghitung total pemasukan, pengeluaran, dan saldo per bulan
        $this->laporanKeuangan = CatatanKeuangan::select(
            DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as periode"), // Format YYYY-MM untuk periode
            DB::raw('COALESCE(SUM(masuk), 0) as total_pemasukan'),
            DB::raw('COALESCE(SUM(keluar), 0) as total_pengeluaran'),
            DB::raw('COALESCE(SUM(masuk), 0) - COALESCE(SUM(keluar), 0) as saldo_akhir')
        )
        ->groupBy('periode')
        ->orderBy('periode', 'asc')
        ->get();

        // Hitung total pemasukan, pengeluaran, dan saldo akhir dari seluruh data
        $this->totalPemasukan = $this->getTotalPemasukan();
        $this->totalPengeluaran = $this->getTotalPengeluaran();
        $this->saldoAkhir = $this->totalPemasukan - $this->totalPengeluaran;
    }

    protected function getTotalPemasukan(): float
    {
        return CatatanKeuangan::sum('masuk');
    }

    protected function getTotalPengeluaran(): float
    {
        return CatatanKeuangan::sum('keluar');
    }

    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
}
