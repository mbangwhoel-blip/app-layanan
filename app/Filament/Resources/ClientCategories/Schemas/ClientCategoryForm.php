<?php

namespace App\Filament\Resources\ClientCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori PPKS')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori PPKS')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('contoh: Anak Terlantar, Disabilitas Fisik, Lansia Terlantar'),
                        Textarea::make('description')
                            ->label('Deskripsi / Definisi Kategori')
                            ->rows(3)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}
