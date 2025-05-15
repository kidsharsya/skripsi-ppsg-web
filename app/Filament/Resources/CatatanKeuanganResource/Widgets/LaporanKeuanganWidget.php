<?php

namespace App\Filament\Resources\CatatanKeuanganResource\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\CatatanKeuangan;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganWidget extends BaseWidget
{
    protected static string $view = 'filament.resources.catatan-keuangan-resource.widgets.laporan-keuangan-widget';

    public $totalPemasukan;
    public $totalPengeluaran;
    public $saldoAkhir;

    public function mount()
    {
        // Hitung total pemasukan
        $this->totalPemasukan = $this->getTotalPemasukan();
        
        // Hitung total pengeluaran
        $this->totalPengeluaran = $this->getTotalPengeluaran();
        
        // Hitung saldo akhir
        $this->saldoAkhir = $this->totalPemasukan - $this->totalPengeluaran;
    }

    protected function getTotalPemasukan(): float
    {
        return (float) CatatanKeuangan::sum('masuk') ?? 0;
    }

    protected function getTotalPengeluaran(): float
    {
        return (float) CatatanKeuangan::sum('keluar') ?? 0;
    }
}
