<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Anggota;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AnggotaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AnggotaResource\RelationManagers;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static ?string $navigationLabel = 'Manajemen Anggota';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'email')
                    ->label('User ID')
                    ->options(function () {
                        return User::where('role', 'user')
                            ->whereDoesntHave('anggota')
                            ->pluck('email', 'id');
                    })
                    ->disabled(fn (Get $get, $state, $context) => $context === 'edit'),

                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Nama'),

                Forms\Components\TextInput::make('tempat_tgl_lahir')
                    ->required()
                    ->label('Tempat, Tanggal Lahir'),

                Forms\Components\Select::make('jenis_kelamin')
                    ->required()
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->label('Jenis Kelamin'),

                Forms\Components\TextInput::make('agama')
                    ->required()
                    ->label('Agama'),

                Forms\Components\Select::make('rt')
                    ->required()
                    ->options([
                        '01' => '01',
                        '02' => '02',
                        '03' => '03',
                        '04' => '04',
                        '05' => '05',
                        '06' => '06',
                    ])
                    ->label('RT'),

                Forms\Components\Select::make('gol_darah')
                    ->required()
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'AB' => 'AB',
                        '0' => 'O',
                        'Tidak tahu' => 'Tidak tahu',
                    ])
                    ->label('Golongan Darah'),

                Forms\Components\TextInput::make('no_hp')
                    ->required()
                    ->label('Nomor HP'),

                Forms\Components\Select::make('status_keanggotaan')
                    ->required()
                    ->options([
                        'aktif' => 'Aktif',
                        'pasif' => 'Pasif',
                        'tidak aktif' => 'Tidak Aktif',
                    ])
                    ->label('Status Keanggotaan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tempat_tgl_lahir')
                    ->label('Tempat dan Tanggal Lahir')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('agama')
                    ->label('Agama')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('rt')
                    ->label('RT')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('gol_darah')
                    ->label('Gol Darah')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No HP')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status_keanggotaan')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => Str::ucfirst($state))
                    ->color(fn ($state) => match ($state) {
                        'aktif' => 'success',       // hijau
                        'pasif' => 'warning',       // kuning
                        'tidak aktif' => 'danger',  // merah
                        default => 'gray',
                    }),
            ])
            ->filters([
                    Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->label('Jenis 
                    Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->placeholder('Semua')
                    ->default(null),
                
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

                    Tables\Filters\SelectFilter::make('gol_darah')
                    ->label('Golongan Darah')
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'AB' => 'AB',
                        'O' => 'O',
                        'Tidak tahu' => 'Tidak tahu',
                    ])
                    ->placeholder('Semua')
                    ->default(null),

                    Tables\Filters\SelectFilter::make('status_keanggotaan')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'pasif' => 'Pasif',
                        'tidak aktif' => 'Tidak Aktif',
                    ])
                    ->placeholder('Semua')
                    ->default(null),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Export pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                            $anggotas = \App\Models\Anggota::all();

                            $pdf = Pdf::loadView('anggota', [
                            'anggotas' => $anggotas,
                            ])->setPaper('A4', 'landscape');

            return response()->streamDownload(
                fn () => print($pdf->stream()),
                'data_anggota.pdf'
                    );
                }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnggotas::route('/'),
            'create' => Pages\CreateAnggota::route('/create'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
        ];
    }
}
