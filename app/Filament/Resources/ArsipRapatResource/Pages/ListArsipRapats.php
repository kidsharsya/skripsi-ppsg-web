<?php

namespace App\Filament\Resources\ArsipRapatResource\Pages;

use App\Filament\Resources\ArsipRapatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArsipRapats extends ListRecords
{
    protected static string $resource = ArsipRapatResource::class;

    public function getTitle(): string
    {
        return 'Arsip Rapat';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Arsip'),
        ];
    }
}
