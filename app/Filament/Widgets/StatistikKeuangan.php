<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\CatatanKeuangan;
use Illuminate\Support\Facades\DB;

class StatistikKeuangan extends ChartWidget
{
    protected static ?string $heading = 'Statistik Keuangan 6 Bulan Terakhir';

    protected function getData(): array
    {
         $data = CatatanKeuangan::whereBetween('tanggal', [Carbon::now()->subMonths(6), Carbon::now()])
            ->orderBy('tanggal')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->locale('id')->translatedFormat('F Y');
            })
            ->map(function ($group) {
                return [
                    'masuk' => $group->sum('masuk'),
                    'keluar' => $group->sum('keluar'),
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $data->pluck('masuk')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $data->pluck('keluar')->toArray(),
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => 'rgb(239, 68, 68)',
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected static ?int $sort = 6;
}
