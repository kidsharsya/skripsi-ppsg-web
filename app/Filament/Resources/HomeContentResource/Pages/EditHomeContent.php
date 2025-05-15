<?php

namespace App\Filament\Resources\HomeContentResource\Pages;

use App\Filament\Resources\HomeContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeContent extends EditRecord
{
    protected static string $resource = HomeContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
