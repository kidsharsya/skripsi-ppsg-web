<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\ArsipRapat;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArsipRapatResource\Pages;
use App\Filament\Resources\ArsipRapatResource\RelationManagers;

class ArsipRapatResource extends Resource
{
    protected static ?string $model = ArsipRapat::class;

    protected static ?string $navigationLabel = 'Manajemen Arsip Rapat';
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul_rapat')
                ->label('Judul Rapat')
                ->required(),
                Forms\Components\DatePicker::make('tanggal_rapat')
                ->label('Tanggal Rapat')
                ->required(),
                Forms\Components\MarkdownEditor::make('notulensi')
                ->label('Notulensi Rapat')
                ->required()
                ->columnSpan(2),
                Forms\Components\FileUpload::make('dokumentasi')
                ->label('Foto Dokumentasi')
                ->disk('public')
                ->directory('dokumentasi_rapat')
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_rapat')->label('Judul Rapat'),
                Tables\Columns\TextColumn::make('tanggal_rapat')
                ->label('Tanggal Rapat')
                ->sortable()
                ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->locale('id')->translatedFormat('d F Y')),

                Tables\Columns\TextColumn::make('notulensi')
                ->label('Notulensi')
                ->html() // Menandakan bahwa konten adalah HTML
                ->formatStateUsing(fn ($state) => \Illuminate\Support\Str::markdown($state))
                ->limit(300)
                ->wrap(),

                Tables\Columns\ImageColumn::make('dokumentasi')
                ->label('Foto Dokumentasi')
                ->size(100),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function ($record) {
                    $pdf = Pdf::loadView('arsip-rapat', [
                    'arsip' => $record,
                ]);

                return response()->streamDownload(
                fn () => print($pdf->stream()),
                    'Notulensi-' . $record->judul_rapat . '-' . Carbon::parse($record->tanggal_rapat)->locale('id')->translatedFormat('d-M-Y') . '.pdf'
                    );
                }),
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
            'index' => Pages\ListArsipRapats::route('/'),
            'create' => Pages\CreateArsipRapat::route('/create'),
            'edit' => Pages\EditArsipRapat::route('/{record}/edit'),
        ];
    }
}
