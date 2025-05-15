<?php

namespace App\Filament\Resources\CatatanIuranResource\Pages;

use App\Filament\Resources\CatatanIuranResource;
use Filament\Resources\Pages\Page;

class LaporanKeuangan extends Page
{
    protected static string $resource = CatatanIuranResource::class;

    protected static string $view = 'filament.resources.catatan-iuran-resource.pages.laporan-keuangan';
}
