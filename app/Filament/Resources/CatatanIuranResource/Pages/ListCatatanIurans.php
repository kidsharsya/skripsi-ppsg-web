<?php

namespace App\Filament\Resources\CatatanIuranResource\Pages;

use App\Filament\Resources\CatatanIuranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatatanIurans extends ListRecords
{
    protected static string $resource = CatatanIuranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Catatan Iuran/Kas Anggota';
    }
}
