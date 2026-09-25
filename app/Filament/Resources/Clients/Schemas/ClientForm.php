<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Klien / PPKS')
                    ->description('Data personal Pemerlu Pelayanan Kesejahteraan Sosial')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap Klien')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Nama lengkap sesuai KTP / Dokumen kependudukan'),
                            Select::make('client_category_id')
                                ->label('Kategori PPKS')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('nik')
                                ->label('NIK Klien (16 Digit)')
                                ->length(16)
                                ->numeric()
                                ->placeholder('Kosongkan jika ODGJ / Terlantar tanpa identitas'),
                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options(Gender::class)
                                ->required(),
                            DatePicker::make('birth_date')
                                ->label('Tanggal Lahir')
                                ->placeholder('Pilih jika diketahui'),
                            TextInput::make('phone')
                                ->label('Nomor Telepon / Kontak Keluarga')
                                ->tel()
                                ->maxLength(20)
                                ->placeholder('08xxxxxxxxxx'),
                        ]),
                    ]),

                Section::make('Domisili & Tempat Tinggal')
                    ->schema([
                        Select::make('village_id')
                            ->label('Desa / Kelurahan Domisili')
                            ->relationship('village', 'name')
                            ->searchable()
                            ->preload(),
                        Textarea::make('address')
                            ->label('Alamat Lengkap / Lokasi Ditemukan')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Alamat rumah atau lokasi saat penjangkauan/ditemukan'),
                    ]),
            ]);
    }
}
