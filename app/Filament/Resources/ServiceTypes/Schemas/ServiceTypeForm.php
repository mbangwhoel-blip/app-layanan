<?php

namespace App\Filament\Resources\ServiceTypes\Schemas;

use App\Enums\ServiceRequestHandler;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('code')
                                ->label('Kode Layanan')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(50)
                                ->placeholder('contoh: DTSEN, PBI_JK'),
                            TextInput::make('name')
                                ->label('Nama Layanan')
                                ->required()
                                ->maxLength(150)
                                ->placeholder('contoh: Surat Rekomendasi Terdaftar DTSEN'),
                            TextInput::make('category')
                                ->label('Kategori')
                                ->maxLength(100)
                                ->placeholder('contoh: Bantuan Sosial, Perlindungan Sosial'),
                            Select::make('handler')
                                ->label('Handler / Modul Khusus')
                                ->options(ServiceRequestHandler::class)
                                ->default('generic')
                                ->required()
                                ->helperText('Pilih DTSEN atau PBI untuk form khusus, atau Generic untuk layanan standar'),
                            TextInput::make('sla_days')
                                ->label('SLA / Target Waktu Penyelesaian (Hari)')
                                ->numeric()
                                ->default(3)
                                ->suffix('Hari Kerja'),
                            Toggle::make('needs_assessment')
                                ->label('Memerlukan Asesmen Lapangan')
                                ->default(false),
                            Toggle::make('is_active')
                                ->label('Layanan Aktif')
                                ->default(true),
                        ]),
                        Textarea::make('description')
                            ->label('Deskripsi & Penjelasan Layanan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
