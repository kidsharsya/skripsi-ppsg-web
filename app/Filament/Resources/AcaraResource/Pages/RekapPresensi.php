<?php

namespace App\Filament\Resources\AcaraResource\Pages;

use Filament\Tables;
use App\Models\Anggota;
use App\Models\Presensi;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use App\Filament\Resources\AcaraResource;
use Filament\Tables\Concerns\InteractsWithTable;

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
            TextColumn::make('persentase_kehadiran')
                ->label('% Kehadiran')
                ->getStateUsing(function ($record) {
                    if ($record->total_kegiatan == 0) return 0;
                    return round(($record->hadir_count / $record->total_kegiatan) * 100, 1);
                })
                ->formatStateUsing(fn ($state) => $state . '%')
                ->badge()
                ->color(function ($record) {
                    if ($record->total_kegiatan == 0) return 'gray';
                    $persentase = ($record->hadir_count / $record->total_kegiatan) * 100;
                    if ($persentase >= 80) return 'success';
                    if ($persentase >= 60) return 'warning';
                    return 'danger';
                }),

            // TextColumn::make('status_keaktifan')
            //     ->label('Status')
            //     ->alignment(Alignment::Center)
            //     ->getStateUsing(function ($record) {
            //         if ($record->total_kegiatan == 0) return 'Belum Ada Data';
            //         $persentase = ($record->hadir_count / $record->total_kegiatan) * 100;
            //         if ($persentase >= 80) return 'Aktif';
            //         if ($persentase >= 60) return 'Cukup Aktif';
            //         return 'Kurang Aktif';
            //     })
            //     ->badge()
            //     ->color(function ($record) {
            //         if ($record->total_kegiatan == 0) return 'gray';
            //         $persentase = ($record->hadir_count / $record->total_kegiatan) * 100;
            //         if ($persentase >= 80) return 'success';
            //         if ($persentase >= 60) return 'warning';
            //         return 'danger';
            //     }),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Action::make('view_detail')
                ->label('Detail')
                ->icon('heroicon-o-eye')
                ->color('primary')
                ->modalHeading(fn ($record) => 'Detail Presensi - ' . $record->nama)
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup')
                ->modalContent(function ($record) {
                    $presensis = Presensi::with('acara')
                    ->where('anggota_id', $record->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                    return view('filament.components.detail-presensi-anggota', [
                        'presensis' => $presensis
                    ]);
                }),
        ];
    }
}
