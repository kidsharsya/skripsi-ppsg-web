<?php

namespace App\Filament\Resources\ArsipRapatResource\Pages;

use App\Filament\Resources\ArsipRapatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArsipRapat extends EditRecord
{
    protected static string $resource = ArsipRapatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
