<?php

namespace App\Filament\Resources\HomeContentResource\Pages;

use App\Filament\Resources\HomeContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeContents extends ListRecords
{
    protected static string $resource = HomeContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
