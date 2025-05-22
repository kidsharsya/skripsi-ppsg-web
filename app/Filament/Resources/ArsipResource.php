<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipResource\Pages;
use App\Filament\Resources\ArsipResource\RelationManagers;
use App\Models\Arsip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArsipResource extends Resource
{
    protected static ?string $model = Arsip::class;

    protected static ?string $navigationLabel = 'Manajemen Arsip Program Kerja';
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kegiatan')
                ->required()
                ->label('Nama Kegiatan'),

                Forms\Components\DatePicker::make('tanggal_kegiatan')
                ->required()
                ->label('Tanggal Kegiatan'),

                Forms\Components\TextInput::make('proposal')
                ->url()
                ->label('Link Proposal (Google Drive)'),

                Forms\Components\TextInput::make('lpj')
                ->url()
                ->label('Link LPJ (Google Drive)'),

                Forms\Components\TextInput::make('dokumentasi')
                ->url()
                ->label('Link Dokumentasi (Google Drive)'),

                Forms\Components\TextInput::make('dokumen_lain')
                ->url()
                ->label('Link Dokumen Lain (Google Drive)')
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan')
                ->label('Nama Kegiatan')
                ->sortable()
                ->searchable(),
            
                Tables\Columns\TextColumn::make('tanggal_kegiatan')
                ->label('Tanggal Kegiatan')
                ->sortable()
                ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->locale('id')->translatedFormat('d F Y')),

                Tables\Columns\TextColumn::make('proposal')
                ->label('Proposal')
                ->url(fn ($record) => $record->proposal)
                ->openUrlInNewTab()
                ->formatStateUsing(fn ($state) => $state 
                    ? '<span style="color: #6D96FF; text-decoration: underline;">Lihat Proposal</span>' 
                    : 'Tidak Ada')
                ->html(),

                Tables\Columns\TextColumn::make('lpj')
                ->label('LPJ')
                ->url(fn ($record) => $record->lpj)
                ->openUrlInNewTab()
                ->formatStateUsing(fn ($state) => $state 
                    ? '<span style="color: #6D96FF; text-decoration: underline;">Lihat LPJ</span>' 
                    : 'Tidak Ada')
                ->html(),

                Tables\Columns\TextColumn::make('dokumentasi')
                ->label('Dokumentasi')
                ->url(fn ($record) => $record->dokumentasi)
                ->openUrlInNewTab()
                ->formatStateUsing(fn ($state) => $state 
                    ? '<span style="color: #6D96FF; text-decoration: underline;">Lihat Dokumentasi</span>' 
                    : 'Tidak Ada')
                ->html(),

                Tables\Columns\TextColumn::make('dokumen_lain')
                ->label('Dokumen Lain')
                ->url(fn ($record) => $record->dokumen_lain)
                ->openUrlInNewTab()
                ->formatStateUsing(fn ($state) => $state 
                    ? '<span style="color: #6D96FF; text-decoration: underline;">Lihat Dokumen Lain</span>' 
                    : 'Tidak Ada')
                ->html(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArsips::route('/'),
            'create' => Pages\CreateArsip::route('/create'),
            'edit' => Pages\EditArsip::route('/{record}/edit'),
        ];
    }
}
