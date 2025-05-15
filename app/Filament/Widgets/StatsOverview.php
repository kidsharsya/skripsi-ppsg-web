<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Arsip;
use App\Models\Anggota;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::count())
            ->description('Increase in users')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([7, 3, 4, 5, 6, 3, 5, 10]),

            Stat::make('Total Anggota', Anggota::count())
            ->description('Increase in anggota')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('danger')
            ->chart([7, 3, 4, 5, 6, 3, 5, 10]),

            Stat::make('Total Arsip', Arsip::count())
            ->description('Total arsip in app')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('info')
            ->chart([7, 3, 4, 5, 6, 3, 5, 10]),
        ];
    }
}
