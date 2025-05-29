<?php

namespace App\Filament\Resources\AnggotaResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AnggotaResource;
use App\Filament\Resources\AnggotaResource\Widgets\StatistikAnggota;

class ListAnggotas extends ListRecords
{
    protected static string $resource = AnggotaResource::class;

    public function getTitle(): string
    {
        return 'Data Anggota PPSG Candisingo';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Anggota'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatistikAnggota::class,
        ];
    }
}
