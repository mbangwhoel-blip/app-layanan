<?php

namespace App\Filament\Resources\InformationPages\Schemas;

use App\Enums\InformationCategory;
use App\Enums\PublishStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class InformationPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama & Publikasi')
                    ->description('Judul, kategori informasi, dan status tayang di portal publik')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Judul Halaman / Layanan')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set(
                                    'slug',
                                    Str::slug($state ?? ''),
                                ))
                                ->placeholder('contoh: Panduan Layanan Surat Rekomendasi Terdaftar DTSEN'),
                            TextInput::make('slug')
                                ->label('Slug URL Publik')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->placeholder('panduan-layanan-surat-rekomendasi-dtsen'),
                            Select::make('category')
                                ->label('Kategori Informasi')
                                ->options(InformationCategory::class)
                                ->default(InformationCategory::Program)
                                ->required(),
                            Select::make('service_type_id')
                                ->label('Terkait Jenis Layanan (Jika Ada)')
                                ->relationship('serviceType', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih layanan'),
                            Select::make('publish_status')
                                ->label('Status Tayang')
                                ->options(PublishStatus::class)
                                ->default(PublishStatus::Draft)
                                ->required(),
                            DateTimePicker::make('published_at')
                                ->label('Waktu Diterbitkan')
                                ->default(now()),
                            Select::make('manager_id')
                                ->label('Petugas Pengelola Informasi')
                                ->relationship('manager', 'name')
                                ->searchable()
                                ->preload()
                                ->default(auth()->id()),
                        ]),
                    ]),

                Section::make('Uraian Panduan, Persyaratan & Alur Prosedur')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi Singkat / Pengantar Layanan')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Penjelasan mengenai tujuan dan manfaat program layanan ini'),
                        Textarea::make('requirements')
                            ->label('Daftar Persyaratan & Kriteria Penerima')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder("Tuliskan poin-poin persyaratan, contoh:\n1. Fotokopi KTP dan KK\n2. Surat pengantar RT/RW\n3. Surat Keterangan Tidak Mampu"),
                        Textarea::make('procedure')
                            ->label('Alur / Prosedur Pengajuan')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder("Tuliskan langkah-langkah alur permohonan, contoh:\n1. Pemohon mendaftar online atau datang ke loket\n2. Verifikasi berkas oleh petugas\n3. Penerbitan surat rekomendasi"),
                    ]),

                Section::make('Lokasi, Waktu Pelayanan & Kontak')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('service_hours')
                                ->label('Waktu / Jam Pelayanan')
                                ->placeholder('Senin - Kamis: 08.00 - 15.00 WIB, Jumat: 08.00 - 14.30 WIB')
                                ->maxLength(255),
                            TextInput::make('location')
                                ->label('Lokasi / Tempat Pelayanan')
                                ->placeholder('Gedung Pelayanan Terpadu Dinsos Kab. Blitar, Jl. Sudirman No. 10')
                                ->maxLength(255),
                            TextInput::make('contact')
                                ->label('Kontak / Call Center')
                                ->placeholder('WhatsApp: 081234567890 | Email: dinsos@blitarkab.go.id')
                                ->maxLength(255),
                        ]),
                    ]),
            ]);
    }
}
