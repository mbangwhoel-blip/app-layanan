<?php

namespace App\Filament\Resources\DtsenPurposes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DtsenPurposeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Keperluan Rekomendasi DTSEN')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('code')
                                ->label('Kode Keperluan')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(50)
                                ->placeholder('contoh: BEASISWA, KERINGANAN_RS'),
                            TextInput::make('name')
                                ->label('Nama Keperluan / Tujuan')
                                ->required()
                                ->maxLength(150)
                                ->placeholder('contoh: Pengajuan Beasiswa Pendidikan'),
                            TextInput::make('max_decile')
                                ->label('Batas Maksimal Desil')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(10)
                                ->default(4)
                                ->helperText('Keluarga pemohon harus berada pada desil <= nilai ini (misal desil 1-4)'),
                            TextInput::make('validity_days')
                                ->label('Masa Berlaku Surat (Hari)')
                                ->numeric()
                                ->default(30)
                                ->suffix('Hari Kalender'),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
