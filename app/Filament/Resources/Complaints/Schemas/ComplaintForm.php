<?php

namespace App\Filament\Resources\Complaints\Schemas;

use App\Enums\ComplaintStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Aduan Masuk')
                    ->description('Nomor aduan, kategori, dan deskripsi permasalahan')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('complaint_number')
                                ->label('Nomor Aduan')
                                ->placeholder('Dibuat otomatis oleh sistem')
                                ->disabled()
                                ->dehydrated(false),
                            Select::make('complaint_category_id')
                                ->label('Kategori Aduan')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            DateTimePicker::make('reported_at')
                                ->label('Waktu Aduan Dilaporkan')
                                ->default(now()),
                        ]),
                        Textarea::make('description')
                            ->label('Uraian Lengkap Pengaduan')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Jelaskan detail permasalahan, kronologi kejadian, dan pihak-pihak terkait'),
                    ]),

                Section::make('Lokasi & Data Pelapor')
                    ->description('Lokasi kejadian dan informasi kontak pelapor')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('village_id')
                                ->label('Desa / Kelurahan Lokasi Kejadian')
                                ->relationship('village', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('reporter_name')
                                ->label('Nama Pelapor')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Nama warga pelapor'),
                            TextInput::make('reporter_phone')
                                ->label('Nomor WhatsApp / HP Pelapor')
                                ->tel()
                                ->required()
                                ->maxLength(20)
                                ->placeholder('08xxxxxxxxxx'),
                            Select::make('reporter_id')
                                ->label('Akun Pelapor Terdaftar (Jika Ada)')
                                ->relationship('reporter', 'name')
                                ->searchable()
                                ->preload(),
                        ]),
                        Textarea::make('location_detail')
                            ->label('Detail Lokasi / Patokan Tempat')
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('RT/RW, nama jalan, patokan bangunan sekitar'),
                    ]),

                Section::make('Penugasan & Tindak Lanjut Petugas')
                    ->description('Status penanganan, verifikasi, dan penyelesaian aduan')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('officer_id')
                                ->label('Petugas Tindak Lanjut')
                                ->relationship('officer', 'name')
                                ->searchable()
                                ->preload()
                                ->default(auth()->id()),
                            Select::make('status')
                                ->label('Status Aduan')
                                ->options(ComplaintStatus::class)
                                ->default(ComplaintStatus::Received)
                                ->required(),
                            DateTimePicker::make('resolved_at')
                                ->label('Waktu Selesai Ditangani'),
                        ]),
                        Grid::make(2)->schema([
                            Textarea::make('verification_result')
                                ->label('Hasil Verifikasi Awal Lapangan')
                                ->rows(2)
                                ->placeholder('Catatan verifikasi kebenaran laporan'),
                            Textarea::make('action_taken')
                                ->label('Tindakan / Solusi yang Diberikan')
                                ->rows(2)
                                ->placeholder('Solusi atau intervensi dinas sosial'),
                        ]),
                    ]),
            ]);
    }
}
