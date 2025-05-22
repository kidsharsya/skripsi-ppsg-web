<?php

namespace App\Filament\Resources\CatatanIuranResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AnggotaRelationManager extends RelationManager
{
    protected static string $relationship = 'anggota';
    protected static ?string $recordTitleAttribute = 'nama';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                ->searchable(),
                Tables\Columns\IconColumn::make('pivot.status_bayar')
                    ->label('Status Bayar')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        $catatanIuran = $this->ownerRecord;
                        $anggotaList = $catatanIuran->anggota()->get();

                        $pdf = Pdf::loadView('catatan-iuran', [
                        'catatanIuran' => $catatanIuran,
                        'anggotaList' => $anggotaList,
            ]);

            $filename = 'catatan-iuran-rt_' . $this->getOwnerRecord()->rt . '_' . $this->getOwnerRecord()->tanggal_pertemuan . '.pdf';

            return response()->streamDownload(
                fn () => print($pdf->stream()),
                $filename
            );
        }),
            ])
            ->actions([
                Action::make('toggleBayar')
                    ->label(fn ($record) => $record->pivot->status_bayar ? 'Tandai Belum Bayar' : 'Tandai Sudah Bayar')
                    ->icon(fn ($record) => $record->pivot->status_bayar ? 'heroicon-o-x-mark' : 'heroicon-o-check')
                    ->color(fn ($record) => $record->pivot->status_bayar ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => $record->pivot->status_bayar ? 
                        "Ubah status {$record->nama} menjadi belum bayar?" : 
                        "Ubah status {$record->nama} menjadi sudah bayar?")
                    ->modalDescription(fn ($record) => $record->pivot->status_bayar ? 
                        "Anggota ini akan ditandai sebagai belum membayar iuran." : 
                        "Anggota ini akan ditandai sebagai sudah membayar iuran.")
                    ->action(function ($record) {
                        $currentStatus = $record->pivot->status_bayar;
                        $newStatus = !$currentStatus;
                        
                        $record->pivot->update([
                            'status_bayar' => $newStatus,
                        ]);
                        
                        $message = $newStatus ? 
                            "{$record->nama} telah ditandai sebagai sudah bayar." : 
                            "{$record->nama} telah ditandai sebagai belum bayar.";
                            
                        Notification::make()
                            ->title('Status pembayaran diperbarui')
                            ->body($message)
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
