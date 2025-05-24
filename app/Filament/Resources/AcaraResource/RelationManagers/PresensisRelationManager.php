<?php

namespace App\Filament\Resources\AcaraResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PresensisRelationManager extends RelationManager
{
    protected static string $relationship = 'presensis';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('anggota_id')
                    ->relationship('anggota', 'nama')
                    ->disabled()
                    ->label('Nama Anggota'),
                Forms\Components\Select::make('status')
                    ->label('Status Presensi')
                    ->options([
                        'Hadir' => 'Hadir',
                        'Tidak Hadir' => 'Tidak Hadir',
                        'Izin' => 'Izin',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                Tables\Columns\TextColumn::make('anggota.nama')
                    ->label('Nama Anggota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => Str::ucfirst($state)),
                Tables\Columns\TextColumn::make('alasan')
                    ->label('Alasan (Jika Izin)'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        $presensis = $this->getOwnerRecord()->presensis()->with('anggota')->get();

                        $pdf = Pdf::loadView('presensi', [
                        'acara' => $this->getOwnerRecord(),
                        'presensis' => $presensis,
            ]);

            $filename = 'presensi_' . $this->getOwnerRecord()->nama . $this->getOwnerRecord()->waktu_mulai . '.pdf';

            return response()->streamDownload(
                fn () => print($pdf->stream()),
                $filename
            );
        }),
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

}
