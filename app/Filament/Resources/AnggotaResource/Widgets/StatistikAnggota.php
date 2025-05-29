<?php

namespace App\Filament\Resources\AnggotaResource\Widgets;

use App\Models\Anggota;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatistikAnggota extends BaseWidget
{
    protected static string $view = 'filament.resources.anggota-resource.widgets.statistik-anggota';

    public function getViewData(): array
    {
        return [
            'jumlahRt01' => Anggota::where('rt', '01')->count(),
            'jumlahRt02' => Anggota::where('rt', '02')->count(),
            'jumlahRt03' => Anggota::where('rt', '03')->count(),
            'jumlahRt04' => Anggota::where('rt', '04')->count(),
            'jumlahRt05' => Anggota::where('rt', '05')->count(),
            'jumlahRt06' => Anggota::where('rt', '06')->count(),
            'jumlahLaki' => Anggota::where('jenis_kelamin', 'Laki-laki')->count(),
            'jumlahPerempuan' => Anggota::where('jenis_kelamin', 'Perempuan')->count(),
        ];
    }
}
