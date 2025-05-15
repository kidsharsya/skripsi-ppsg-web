<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeContentResource\Pages;
use App\Filament\Resources\HomeContentResource\RelationManagers;
use App\Models\HomeContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeContentResource extends Resource
{
    protected static ?string $model = HomeContent::class;
    protected static ?string $navigationLabel = 'Hero Section';
    protected static ?string $navigationGroup = 'Manajemen Konten Home';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Hero Section')
                ->schema([
                    Forms\Components\TextInput::make('hero_title')
                        ->label('Judul Hero')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('hero_subtitle')
                        ->label('Subtitle Hero')
                        ->rows(3),
                    Forms\Components\FileUpload::make('banner_image')
                        ->label('Banner Image')
                        ->image()
                        ->directory('home-banners')
                        ->maxSize(2048),
                ])->columns(1),
                
            Forms\Components\Section::make('Informasi Organisasi')
                ->schema([
                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Tentang Organisasi')
                        ->rows(4),
                    Forms\Components\Textarea::make('visi')
                        ->label('Visi')
                        ->rows(3),
                    Forms\Components\Repeater::make('misi')
                        ->schema([
                            Forms\Components\TextInput::make('value')
                                ->label('Poin Misi')
                                ->required(),
                        ])
                        ->label('Misi')
                        ->default([])
                        ->columns(1)
                        ->reorderable(true)
                        ->addActionLabel('Tambah Misi')
                        ->itemLabel(fn (array $state): ?string => $state['value'] ?? null),
                ])->columns(1),

                Forms\Components\Section::make('Judul Tiap Section di Halaman Home')
                ->schema([
                    Forms\Components\TextInput::make('section1')
                    ->label('Judul Section 1 (Tentang Organisasi)'),
                    Forms\Components\TextInput::make('section2')
                    ->label('Judul Section 2 (Pencapaian Kami)'),
                    Forms\Components\TextInput::make('section3')
                    ->label('Judul Section 3 (Struktur Kepengurusan)'),
                    Forms\Components\TextInput::make('section4')
                    ->label('Judul Section 4 (Galeri Dokumentasi)'),
                    Forms\Components\TextInput::make('section5')
                    ->label('Judul Section 5 (Testimoni)'),
                    Forms\Components\TextInput::make('section6')
                    ->label('Judul Section 6 (Lokasi Kami)'),
        ])->columns(2),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('hero_title')
                ->label('Judul Hero')
                ->wrap()
                ->markdown(),

            Tables\Columns\TextColumn::make('hero_subtitle')
                ->label('Subtitle Hero')
                ->wrap()
                ->markdown(),

            Tables\Columns\TextColumn::make('deskripsi')
                ->label('Tentang Organisasi')
                ->wrap()
                ->markdown(),

            Tables\Columns\ImageColumn::make('banner_image')
                ->label('Banner Image')
                ->height(100),

            Tables\Columns\TextColumn::make('visi')
                ->label('Visi')
                ->wrap()
                ->markdown(),

            Tables\Columns\TextColumn::make('misi_formatted')
                ->label('Misi')
                ->state(function (HomeContent $record): string {
                    if (empty($record->misi) || !is_array($record->misi)) {
                        return '';
                    }
                    
                    $misiPoints = [];
                    foreach ($record->misi as $item) {
                        if (isset($item['value']) && !empty($item['value'])) {
                            $misiPoints[] = $item['value'];
                        }
                    }
                    
                    // Return as bullet points for better readability
                    return '<ul class="list-disc pl-5">' . 
                           implode('', array_map(fn($point) => "<li>$point</li>", $misiPoints)) . 
                           '</ul>';
                })
                ->html()
                ->wrap(),

            Tables\Columns\TextColumn::make('section1')->label('Section 1'),
            Tables\Columns\TextColumn::make('section2')->label('Section 2'),
            Tables\Columns\TextColumn::make('section3')->label('Section 3'),
            Tables\Columns\TextColumn::make('section4')->label('Section 4'),
            Tables\Columns\TextColumn::make('section5')->label('Section 5'),
            Tables\Columns\TextColumn::make('section6')->label('Section 6'),
                
            
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Terakhir Diperbarui')
                ->dateTime('d M Y H:i'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeContents::route('/'),
            'create' => Pages\CreateHomeContent::route('/create'),
            'edit' => Pages\EditHomeContent::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return \App\Models\HomeContent::count() === 0;
    }
}
