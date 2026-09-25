<?php

namespace App\Filament\Resources\Districts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kecamatan')
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Kecamatan')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->placeholder('contoh: 35.05.08'),
                        TextInput::make('name')
                            ->label('Nama Kecamatan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('contoh: Kanigoro'),
                    ])
                    ->columns(2),
            ]);
    }
}
