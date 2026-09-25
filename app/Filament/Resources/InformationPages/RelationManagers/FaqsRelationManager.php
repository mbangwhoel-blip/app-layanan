<?php

namespace App\Filament\Resources\InformationPages\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsRelationManager extends RelationManager
{
    protected static string $relationship = 'faqs';

    protected static ?string $title = 'Tanya Jawab Seputar Halaman Ini (FAQ)';

    protected static ?string $modelLabel = 'FAQ';

    protected static ?string $pluralModelLabel = 'FAQ';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->label('Pertanyaan yang Sering Diajukan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('contoh: Berapa lama waktu penerbitan surat rekomendasi?'),
                Textarea::make('answer')
                    ->label('Jawaban')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Jelaskan jawaban secara ringkas, jelas, dan informatif'),
                TextInput::make('sort_order')
                    ->label('Nomor Urut')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Tampilkan di Publik')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->defaultSort('sort_order', 'asc')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                TextColumn::make('question')
                    ->label('Pertanyaan')
                    ->weight('bold')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('answer')
                    ->label('Jawaban')
                    ->limit(50),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah FAQ'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
