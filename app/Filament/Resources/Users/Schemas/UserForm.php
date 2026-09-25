<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Data identitas dan kredensial login pengguna')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Nama lengkap beserta gelar jika ada'),
                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->placeholder('email@dinsos.blitarkab.go.id'),
                            TextInput::make('password')
                                ->label('Kata Sandi')
                                ->password()
                                ->revealable()
                                ->dehydrated(fn (?string $state): bool => filled($state))
                                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->helperText(fn (string $operation): ?string => $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah kata sandi' : null),
                            TextInput::make('phone')
                                ->label('Nomor Telepon / WhatsApp')
                                ->tel()
                                ->maxLength(20)
                                ->placeholder('081234567890'),
                            TextInput::make('nik')
                                ->label('NIK (16 Digit)')
                                ->length(16)
                                ->numeric()
                                ->unique(ignoreRecord: true)
                                ->placeholder('350508xxxxxxxxxx'),
                        ]),
                    ]),

                Section::make('Hak Akses & Status')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('roles')
                                ->label('Peran / Hak Akses (Role)')
                                ->relationship('roles', 'name')
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->required(),
                            Toggle::make('is_active')
                                ->label('Status Akun Aktif')
                                ->default(true)
                                ->helperText('Pengguna tidak dapat login ke sistem jika status non-aktif')
                                ->required(),
                        ]),
                    ]),

                Section::make('Penugasan Unit Kerja & Wilayah')
                    ->description('Khusus untuk Petugas Dinsos atau Operator Kecamatan/Desa')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('work_unit_id')
                                ->label('Unit Kerja / Bidang')
                                ->relationship('workUnit', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih Unit Kerja (jika di Dinsos)'),
                            Select::make('district_id')
                                ->label('Kecamatan')
                                ->relationship('district', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->placeholder('Pilih Kecamatan'),
                            Select::make('village_id')
                                ->label('Desa / Kelurahan')
                                ->relationship(
                                    'village',
                                    'name',
                                    modifyQueryUsing: fn (Builder $query, Get $get) => $get('district_id') ? $query->where('district_id', $get('district_id')) : $query
                                )
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih Desa'),
                        ]),
                    ]),
            ]);
    }
}
