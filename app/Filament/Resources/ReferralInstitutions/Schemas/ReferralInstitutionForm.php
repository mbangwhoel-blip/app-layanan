<?php

namespace App\Filament\Resources\ReferralInstitutions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReferralInstitutionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Lembaga Rujukan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lembaga Rujukan')
                                ->required()
                                ->maxLength(150)
                                ->placeholder('contoh: Panti Sosial Bina Remaja, RSUD Ngudi Waluyo'),
                            TextInput::make('type')
                                ->label('Jenis / Tipe Lembaga')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('contoh: Panti Sosial, Rumah Sakit, Balai Rehabilitasi'),
                            TextInput::make('contact')
                                ->label('Kontak / Nomor Telepon')
                                ->tel()
                                ->maxLength(100)
                                ->placeholder('contoh: (0342) 801234 atau 08123456789'),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true),
                        ]),
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Alamat jalan, kota, dan lokasi rujukan'),
                    ]),
            ]);
    }
}
