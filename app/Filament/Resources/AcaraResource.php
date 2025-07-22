<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Acara;
use Filament\Forms\Form;
use Pages\RekapPresensi;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AcaraResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AcaraResource\RelationManagers;

class AcaraResource extends Resource
{
    protected static ?string $model = Acara::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Manajemen Presensi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                ->label('Nama Acara')
                ->required()
                ->maxLength(255),

                Forms\Components\Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(3)
                ->nullable(),

                Forms\Components\DateTimePicker::make('waktu_mulai')
                ->label('Waktu Mulai')
                ->required(),

                Forms\Components\DateTimePicker::make('waktu_selesai')
                ->label('Waktu Selesai')
                ->required(),

                Forms\Components\TextInput::make('token')
                ->default(fn () => strtoupper(Str::random(6)))
                ->readOnly()
                ->required()
                ->label('Token Presensi'),

                Forms\Components\TextInput::make('latitude')
                ->required()
                ->numeric()
                ->placeholder('Contoh: -7.87231')
                ->label('Latitude Lokasi'),

                Forms\Components\TextInput::make('longitude')
                ->required()
                ->numeric()
                ->placeholder('Contoh: 110.87621')
                ->label('Longitude Lokasi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Acara')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi'),
                
                Tables\Columns\TextColumn::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)
                        ->locale('id')
                        ->translatedFormat('d F Y H:i:s')),
                    
                Tables\Columns\TextColumn::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)
                        ->locale('id')
                        ->translatedFormat('d F Y H:i:s')),

                Tables\Columns\TextColumn::make('token')
                    ->label('Token'),
                
                Tables\Columns\TextColumn::make('latitude')
                    ->label('Latitude')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('longitude')
                    ->label('Longitude')
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            \App\Filament\Resources\AcaraResource\RelationManagers\PresensisRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcaras::route('/'),
            'create' => Pages\CreateAcara::route('/create'),
            'edit' => Pages\EditAcara::route('/{record}/edit'),
            'rekap' => Pages\RekapPresensi::route('/rekap-presensi'),
            'view' => Pages\ViewAcara::route('/{record}'),
        ];
    }
}
