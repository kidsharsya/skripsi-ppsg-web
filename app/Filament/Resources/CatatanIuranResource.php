<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Anggota;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CatatanIuran;
use App\Models\CatatanKeuangan;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CatatanIuranResource\Pages;
use App\Filament\Resources\CatatanIuranResource\RelationManagers;
use App\Filament\Resources\CatatanIuranResource\RelationManagers\AnggotaRelationManager;

class CatatanIuranResource extends Resource
{
    protected static ?string $model = CatatanIuran::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Manajemen Iuran/Kas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id') 
                    ->label('Penginput')
                    ->default(auth()->user()->id) // Secara otomatis set ID user yang login
                    ->disabled() // Nonaktifkan agar tidak bisa diubah secara manual
                    ->relationship('user', 'name'),
                Forms\Components\DatePicker::make('tanggal_pertemuan')
                ->required(),
                // ->disabled(fn (Get $get, $state, $context) => $context === 'edit'),
                // Select untuk memilih RT
                Forms\Components\Select::make('rt')
                ->label('Pilih RT')
                ->options(
                 Anggota::distinct()->orderBy('rt')->pluck('rt', 'rt')->toArray()
                )
                ->reactive() // Menjadikan elemen ini reactive
                ->afterStateUpdated(function (callable $set) {
                 // Mengosongkan pilihan anggota_id ketika RT berubah
                 $set('anggota_id', []);
                })
                ->required()
                // ->disabled(fn (Get $get, $state, $context) => $context === 'edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_pertemuan')
                ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->locale('id')->translatedFormat('d F Y'))
                ->label('Tanggal Pertemuan')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('rt')
                ->label('RT')
                ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_anggota_rt')
                ->label('Wajib Bayar')
                ->getStateUsing(function ($record) {
                    return \App\Models\Anggota::where('rt', $record->rt)
                    ->whereIn('status_keanggotaan', ['aktif', 'pasif'])
                    ->count();
                }),
                Tables\Columns\TextColumn::make('sudah_bayar')
                ->label('Sudah Bayar')
                ->getStateUsing(function ($record) {
                    return $record->anggota()
                        ->wherePivot('status_bayar', true)
                        ->count();
                    }),
                Tables\Columns\TextColumn::make('belum_bayar')
                ->label('Belum Bayar')
                ->getStateUsing(function ($record) {
                    return $record->anggota()
                        ->wherePivot('status_bayar', false)
                        ->count();
                    }),
                Tables\Columns\TextColumn::make('total_bayar')
                ->label('Total Bayar')
                ->getStateUsing(function ($record) {
                    $sudahBayar = $record->anggota()
                ->wherePivot('status_bayar', true)
                ->count();
                    return 'Rp ' . number_format($sudahBayar * 5000, 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('user.name')
                ->label('Penginput')
                ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rt')
                    ->label('RT')
                    ->options([
                        '01' => '01',
                        '02' => '02',
                        '03' => '03',
                        '04' => '04',
                        '05' => '05',
                        '06' => '06',
                    ])
                    ->placeholder('Semua')
                    ->default(null),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('simpan_ke_keuangan')
                    ->label('Simpan ke Keuangan')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->hidden(function ($record) {
                        return CatatanKeuangan::where('deskripsi', 'LIKE', 'Iuran Kas RT ' . $record->rt . ' - ' . \Carbon\Carbon::parse($record->tanggal_pertemuan)->format('d/m/Y'))->exists();
                    })
                    ->action(function ($record) {
                        // Cek apakah sudah ada catatan keuangan untuk iuran ini
                        if (CatatanKeuangan::where('deskripsi', 'LIKE', 'Iuran Kas RT ' . $record->rt . ' - ' . \Carbon\Carbon::parse($record->tanggal_pertemuan)->format('d/m/Y'))->exists()) {
                            Notification::make()
                                ->warning()
                                ->title('Peringatan')
                                ->body('Data iuran ini sudah disimpan ke catatan keuangan sebelumnya.')
                                ->send();
                            return;
                        }

                        // Hitung total bayar
                        $sudahBayar = $record->anggota()
                            ->wherePivot('status_bayar', true)
                            ->count();
                        $totalBayar = $sudahBayar * 5000;

                        // Simpan ke catatan keuangan
                        CatatanKeuangan::create([
                            'tanggal' => $record->tanggal_pertemuan,
                            'deskripsi' => 'Iuran Kas RT ' . $record->rt . ' - ' . \Carbon\Carbon::parse($record->tanggal_pertemuan)->format('d/m/Y'),
                            'masuk' => $totalBayar,
                            'keluar' => NULL,
                            'user_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Berhasil')
                            ->body('Data iuran berhasil disimpan ke catatan keuangan')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Simpan ke Catatan Keuangan')
                    ->modalDescription('Apakah Anda yakin ingin menyimpan data iuran ini ke catatan keuangan?')
                    ->modalSubmitActionLabel('Ya, Simpan')
                    ->modalCancelActionLabel('Batal'),
                Tables\Actions\Action::make('update_keuangan')
                    ->label('Perbarui Keuangan')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->visible(function ($record) {
                        $keuangan = CatatanKeuangan::where('deskripsi', 'LIKE', 'Iuran Kas RT ' . $record->rt . ' - ' . \Carbon\Carbon::parse($record->tanggal_pertemuan)->format('d/m/Y'))->first();
                        if (!$keuangan) return false;

                        $sudahBayar = $record->anggota()->wherePivot('status_bayar', true)->count();
                        $totalBayar = $sudahBayar * 5000;

                        return $keuangan->masuk != $totalBayar;
                    })
                    ->action(function ($record) {
                        $keuangan = CatatanKeuangan::where('deskripsi', 'LIKE', 'Iuran Kas RT ' . $record->rt . ' - ' . \Carbon\Carbon::parse($record->tanggal_pertemuan)->format('d/m/Y'))->first();
                        
                        $sudahBayar = $record->anggota()->wherePivot('status_bayar', true)->count();
                        $totalBayar = $sudahBayar * 5000;

                        $keuangan->update([
                            'masuk' => $totalBayar
                        ]);

                        Notification::make()
                            ->title('Berhasil')
                            ->body('Catatan keuangan telah diperbarui')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Perbarui Catatan Keuangan')
                    ->modalDescription('Apakah Anda yakin ingin memperbarui data keuangan sesuai jumlah pembayaran terbaru?')
                    ->modalSubmitActionLabel('Ya, Perbarui')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AnggotaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatatanIurans::route('/'),
            'create' => Pages\CreateCatatanIuran::route('/create'),
            'edit' => Pages\EditCatatanIuran::route('/{record}/edit'),
            'view' => Pages\ViewCatatanIuran::route('/{record}'),
        ];
    }
}
