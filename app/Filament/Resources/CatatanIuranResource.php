<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Anggota;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CatatanIuran;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CatatanIuranResource\Pages;
use App\Filament\Resources\CatatanIuranResource\RelationManagers;

class CatatanIuranResource extends Resource
{
    protected static ?string $model = CatatanIuran::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Manajemen Keuangan';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Catatan Iuran/Kas';

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
                ->required(),

                // CheckboxList untuk memilih anggota berdasarkan RT yang dipilih
                Forms\Components\CheckboxList::make('anggota_id')
                ->label('Pilih Anggota')
                ->relationship('anggota')
                ->options(function (callable $get) {
                 // Mengambil nilai RT yang dipilih
                 $selectedRT = $get('rt');
                 
                 // Jika RT dipilih, ambil daftar anggota berdasarkan RT tersebut
                 if ($selectedRT) {
                     return Anggota::where('rt', $selectedRT)
                         ->pluck('nama', 'id')
                         ->toArray();
                 }
                 
                 // Jika tidak ada RT yang dipilih, kembalikan array kosong
                 return [];
                })
                ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_pertemuan')
                ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->locale('id')->translatedFormat('d F Y'))
                ->label('Tanggal Pertemuan')
                ->sortable(),
                Tables\Columns\TextColumn::make('rt')
                ->label('RT')
                ->sortable(),
                Tables\Columns\TextColumn::make('anggota_count')
                ->label('Jumlah Anggota Membayar')
                ->counts('anggota'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatatanIurans::route('/'),
            'create' => Pages\CreateCatatanIuran::route('/create'),
            'edit' => Pages\EditCatatanIuran::route('/{record}/edit'),
        ];
    }
}
