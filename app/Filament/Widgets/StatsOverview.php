<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Arsip;
use App\Models\Anggota;
use App\Models\ArsipRapat;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::count())
            ->description('Users')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),

            Stat::make('Total Anggota', Anggota::count())
            ->description('Anggota')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('danger'),

            Stat::make('Total Arsip Program Kerja', Arsip::count())
            ->description('Arsip Program Kerja')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            // ->chart([7, 3, 4, 5, 6, 3, 5, 10])
            ->color('info'),

            Stat::make('Total Arsip Rapat', ArsipRapat::count())
            ->description('Arsip Rapat')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            // ->chart([7, 3, 4, 5, 6, 3, 5, 10])
            ->color('primary'),
            
        ];
    }
}
