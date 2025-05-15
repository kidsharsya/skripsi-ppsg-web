<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcaraResource\Pages;
use App\Filament\Resources\AcaraResource\RelationManagers;
use App\Models\Acara;
use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcaraResource extends Resource
{
    protected static ?string $model = Acara::class;
    protected static ?string $navigationGroup = 'Manajemen Presensi Kegiatan';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Presensi Kegiatan';
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
                ->label('Latitude Lokasi'),

                Forms\Components\TextInput::make('longitude')
                ->required()
                ->numeric()
                ->label('Longitude Lokasi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi'),
                
                Tables\Columns\TextColumn::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('waktu_selesai')
                    ->label('Waktu Selesai'),

                Tables\Columns\TextColumn::make('token')
                    ->label('Token'),
                
                Tables\Columns\TextColumn::make('latitude')
                    ->label('Latitude'),
                
                Tables\Columns\TextColumn::make('longitude')
                    ->label('Longitude'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        ];
    }
}
