<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Acara;
use App\Models\Presensi;

class StatistikPresensi extends ChartWidget
{
    protected static ?string $heading = 'Statistik Presensi';
    

    protected function getData(): array
    {
        $acaras = Acara::with('presensis')->latest()->take(4)->get(); // Ambil 10 acara terbaru

        $labels = [];
        $hadirData = [];
        $izinData = [];
        $tidakHadirData = [];

        foreach ($acaras as $acara) {
            $labels[] = $acara->nama;

            $hadirData[] = $acara->presensis->where('status', 'Hadir')->count();
            $izinData[] = $acara->presensis->where('status', 'Izin')->count();
            $tidakHadirData[] = $acara->presensis->where('status', 'Tidak Hadir')->count();
        }
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Hadir',
                    'data' => $hadirData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)', // Warna lebih solid
                    'borderColor' => 'rgba(34, 197, 94, 0.8)',
                ],
                [
                    'label' => 'Izin',
                    'data' => $izinData,
                    'backgroundColor' => 'rgba(250, 204, 21, 0.8)',
                    'borderColor' => 'rgba(250, 204, 21, 0.8)',
                ],
                [
                    'label' => 'Tidak Hadir',
                    'data' => $tidakHadirData,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.8)',
                    'borderColor' => 'rgba(239, 68, 68, 0.8)',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected static ?int $sort = 5;
}
