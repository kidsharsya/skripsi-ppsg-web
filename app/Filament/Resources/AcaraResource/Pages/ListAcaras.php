<?php

namespace App\Filament\Resources\AcaraResource\Pages;

use App\Filament\Resources\AcaraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcaras extends ListRecords
{
    protected static string $resource = AcaraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Buat Presensi'),
            Actions\Action::make('Rekap Presensi')
                ->url(route('filament.admin.resources.acaras.rekap')) // pastikan nama route-nya sesuai
                ->icon('heroicon-o-chart-bar')
                ->color('primary'),
        ];
    }

    public function getTitle(): string
    {
        return 'Data Presensi Kegiatan';
    }
}
