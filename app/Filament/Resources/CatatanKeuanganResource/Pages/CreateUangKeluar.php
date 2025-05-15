<?php

namespace App\Filament\Resources\CatatanKeuanganResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CatatanKeuanganResource;

class CreateUangKeluar extends CreateRecord
{
    protected static string $resource = CatatanKeuanganResource::class;
    protected static ?string $model = CatatanKeuangan::class;

    public function getTitle(): string
    {
        return 'Transaksi Uang Keluar';
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

                Forms\Components\TextInput::make('keluar')
                    ->numeric()
                    ->required()
                    ->label('Uang Keluar'),

                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'name')
                    ->label('Penginput')
                    ->options(function () {
                        return User::where('role', 'admin')
                        ->pluck('name', 'id');
                    }),
            ]);
    }
}
