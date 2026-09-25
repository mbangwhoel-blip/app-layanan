<?php

namespace App\Filament\Resources\Villages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VillageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Desa / Kelurahan')
                    ->schema([
                        Select::make('district_id')
                            ->label('Kecamatan')
                            ->relationship('district', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode Desa/Kelurahan')
                            ->required()
                            ->maxLength(25)
                            ->unique(ignoreRecord: true)
                            ->placeholder('contoh: 35.05.08.2001'),
                        TextInput::make('name')
                            ->label('Nama Desa / Kelurahan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('contoh: Satreyan'),
                    ])
                    ->columns(2),
            ]);
    }
}
