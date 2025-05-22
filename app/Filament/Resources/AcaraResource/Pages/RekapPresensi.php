<?php

namespace App\Filament\Resources\AcaraResource\Pages;

use App\Filament\Resources\AcaraResource;
use App\Models\Anggota;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;

class RekapPresensi extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = AcaraResource::class;

    protected static string $view = 'filament.resources.acara-resource.pages.rekap-presensi';

    public function getTableQuery()
    {
        return Anggota::where('status_keanggotaan', '!=', 'tidak aktif')
    ->withCount([
            'presensis as hadir_count' => fn ($q) => $q->where('status', 'Hadir'),
            'presensis as izin_count' => fn ($q) => $q->where('status', 'Izin'),
            'presensis as tidak_hadir_count' => fn ($q) => $q->where('status', 'Tidak Hadir'),
            'presensis as total_kegiatan'
        ]);
    }

    public function getTableColumns(): array
    {
        return [
            TextColumn::make('nama')
            ->label('Nama Anggota')
            ->searchable(),
            TextColumn::make('hadir_count')->label('Hadir'),
            TextColumn::make('izin_count')->label('Izin'),
            TextColumn::make('tidak_hadir_count')->label('Tidak Hadir'),
            TextColumn::make('total_kegiatan')->label('Total Kegiatan'),
        ];
    }
}
