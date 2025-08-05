<?php

namespace App\Filament\Resources\CatatanKeuanganResource\Pages;

use Filament\Forms;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CatatanKeuanganResource;

class CreateUangMasuk extends CreateRecord
{
    protected static string $resource = CatatanKeuanganResource::class;
    protected static ?string $model = CatatanKeuangan::class;

    public function getTitle(): string
    {
        return 'Transaksi Uang Masuk';
    }

    public function form(Form $form): Form
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
                    ->placeholder('Masukkan tanpa titik. Contoh: 50000 (lima puluh ribu)')
                    ->required()
                    ->minValue(0)
                    ->regex('/^[0-9]+$/')
                    ->validationMessages([
                        'regex' => 'Input harus berupa angka tanpa titik/koma'
                        ])
                    ->label('Uang Masuk'),

                Forms\Components\Select::make('user_id') 
                    ->label('Penginput')
                    ->default(auth()->user()->id) // Secara otomatis set ID user yang login
                    ->disabled() // Nonaktifkan agar tidak bisa diubah secara manual
                    ->relationship('user', 'name'),
            ]);
    }
}
