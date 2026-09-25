<?php

namespace App\Filament\Resources\ComplaintCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori Aduan')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori Pengaduan')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('contoh: Bantuan Sosial Tidak Tepat Sasaran, Dugaan Pungli Bansos'),
                        Textarea::make('description')
                            ->label('Deskripsi Kategori')
                            ->rows(3)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}
