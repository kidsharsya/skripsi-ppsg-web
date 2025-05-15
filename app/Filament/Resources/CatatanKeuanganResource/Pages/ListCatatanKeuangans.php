<?php

namespace App\Filament\Resources\CatatanKeuanganResource\Pages;

use App\Filament\Resources\CatatanKeuanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CatatanKeuanganResource\Widgets\LaporanKeuanganWidget;

class ListCatatanKeuangans extends ListRecords
{
    protected static string $resource = CatatanKeuanganResource::class;

    public function getTitle(): string
    {
        return 'Catatan Keuangan';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Uang Masuk')
            ->icon('heroicon-o-arrow-up-circle')
            ->color('success'),
            Actions\Action::make('Uang Keluar')
            ->url(route('filament.admin.resources.catatan-keuangans.uangkeluar'))
            ->icon('heroicon-o-arrow-down-circle')
            ->color('danger'),
            Actions\Action::make('Keuangan Per Bulan') // Menggunakan Actions\Action
                ->url(route('filament.admin.resources.catatan-keuangans.laporanperiode')) 
                ->icon('heroicon-o-book-open'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            LaporanKeuanganWidget::class,
        ];
    }
}
