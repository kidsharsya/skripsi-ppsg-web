<?php

namespace App\Filament\Resources\CatatanIuranResource\Pages;

use App\Filament\Resources\CatatanIuranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCatatanIuran extends CreateRecord
{
    protected static string $resource = CatatanIuranResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $anggotaIds = collect($data)
            ->filter(fn ($value, $key) => str_starts_with($key, 'anggota_rt_'))
            ->flatten()
            ->toArray();
    
        $data['anggota'] = $anggotaIds;
    
        return $data;
    }
}
