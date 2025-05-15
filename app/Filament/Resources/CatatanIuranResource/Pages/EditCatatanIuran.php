<?php

namespace App\Filament\Resources\CatatanIuranResource\Pages;

use App\Filament\Resources\CatatanIuranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatatanIuran extends EditRecord
{
    protected static string $resource = CatatanIuranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
