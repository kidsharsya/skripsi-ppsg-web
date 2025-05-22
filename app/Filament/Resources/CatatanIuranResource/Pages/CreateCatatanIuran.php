<?php

namespace App\Filament\Resources\CatatanIuranResource\Pages;

use App\Filament\Resources\CatatanIuranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Anggota;
use App\Models\CatatanIuran;

class CreateCatatanIuran extends CreateRecord
{
    protected static string $resource = CatatanIuranResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $anggotaIds = collect($data)
    //         ->filter(fn ($value, $key) => str_starts_with($key, 'anggota_rt_'))
    //         ->flatten()
    //         ->toArray();
    
    //     $data['anggota'] = $anggotaIds;
    
    //     return $data;
    // }

    protected function afterCreate(): void
    {
    $catatan = $this->record;
    
    $anggotaList = Anggota::where('rt', $catatan->rt)
        ->where('status_keanggotaan', '!=', 'tidak aktif')
        ->get();

    foreach ($anggotaList as $anggota) {
        $catatan->anggota()->attach($anggota->id, [
            'status_bayar' => false
        ]);
    }
    }
}
