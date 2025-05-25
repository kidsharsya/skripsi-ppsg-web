<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CatatanKeuangan;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CatatanKeuanganResource\Pages;
use App\Filament\Resources\CatatanKeuanganResource\RelationManagers;
use App\Filament\Resources\CatatanKeuanganResource\Widgets\LaporanKeuanganWidget;

class CatatanKeuanganResource extends Resource
{
    protected static ?string $model = CatatanKeuangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Manajemen Keuangan';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                ->required()
                ->label('Tanggal Transaksi'),

                Forms\Components\TextInput::make('deskripsi')
                    ->required()
                    ->label('Deskripsi Transaksi'),

                Forms\Components\TextInput::make('masuk')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Uang Masuk')
                    ->formatStateUsing(fn ($state) => $state !== null ? (int) $state : null)
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('keluar', null))
                    ->hidden(fn (callable $get) => $get('keluar') !== null && $get('keluar') > 0),

                Forms\Components\TextInput::make('keluar')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Uang Keluar')
                    ->formatStateUsing(fn ($state) => $state !== null ? (int) $state : null)
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('masuk', null))
                    ->hidden(fn (callable $get) => $get('masuk') !== null && $get('masuk') > 0),

                Forms\Components\Select::make('user_id') 
                    ->label('Penginput')
                    ->default(auth()->user()->id) // Secara otomatis set ID user yang login
                    ->disabled() // Nonaktifkan agar tidak bisa diubah secara manual
                    ->relationship('user', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->locale('id')->translatedFormat('d F Y')),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('masuk')
                    ->label('Uang Masuk')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 2, ',', '.')),

                Tables\Columns\TextColumn::make('keluar')
                    ->label('Uang Keluar')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 2, ',', '.')),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penginput')
                    ->searchable(),
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
            'index' => Pages\ListCatatanKeuangans::route('/'),
            'create' => Pages\CreateUangMasuk::route('/create-uang-masuk'),
            'uangkeluar' => Pages\CreateUangKeluar::route('/create-uang-keluar'),
            'laporankeuangan' => Pages\LaporanKeuangan::route('/laporan-keuangan'),
            'laporanperiode' => Pages\LaporanKeuanganPeriode::route('/laporan-keuangan-periode'),
            'edit' => Pages\EditCatatanKeuangan::route('/{record}/edit'),
        ];
    }
}
