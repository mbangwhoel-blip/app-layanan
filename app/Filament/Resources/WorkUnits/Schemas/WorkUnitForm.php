<?php

namespace App\Filament\Resources\WorkUnits\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkUnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Unit Kerja / Bidang')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Unit Kerja / Bidang')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('contoh: Bidang Dayasos (Pemberdayaan Sosial)'),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }
}
