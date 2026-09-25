<?php

namespace App\Filament\Resources\ServiceRequests\Schemas;

use App\Enums\ServiceRequestStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ServiceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan & Tiket')
                    ->description('Nomor tiket dan jenis layanan yang dimohonkan')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('request_number')
                                ->label('Nomor Tiket / Registrasi')
                                ->placeholder('Dibuat otomatis oleh sistem')
                                ->disabled()
                                ->dehydrated(false),
                            Select::make('service_type_id')
                                ->label('Jenis Layanan')
                                ->relationship('serviceType', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live(),
                            DateTimePicker::make('submitted_at')
                                ->label('Waktu Masuk')
                                ->default(now()),
                            Toggle::make('is_priority')
                                ->label('Prioritas Tinggi / Mendesak')
                                ->default(false)
                                ->helperText('Tandai jika kondisi gawat darurat sosial atau rujukan darurat RS'),
                        ]),
                    ]),

                Section::make('Identitas Pemohon')
                    ->description('Data KTP dan kartu keluarga pemohon')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('applicant_name')
                                ->label('Nama Lengkap Pemohon')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Sesuai KTP'),
                            TextInput::make('applicant_nik')
                                ->label('NIK Pemohon (16 Digit)')
                                ->required()
                                ->length(16)
                                ->numeric()
                                ->placeholder('3505xxxxxxxxxxxx'),
                            TextInput::make('family_card_number')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->length(16)
                                ->numeric()
                                ->placeholder('3505xxxxxxxxxxxx'),
                            TextInput::make('phone')
                                ->label('Nomor Telepon / WhatsApp')
                                ->tel()
                                ->required()
                                ->maxLength(20)
                                ->placeholder('08xxxxxxxxxx'),
                            Select::make('village_id')
                                ->label('Desa / Kelurahan Domisili')
                                ->relationship('village', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('submitter_id')
                                ->label('Akun Pengaju / Pelapor')
                                ->relationship('submitter', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih pengguna jika diajukan via akun terdaftar'),
                        ]),
                        Textarea::make('address')
                            ->label('Alamat Lengkap (RT/RW, Dusun/Jalan)')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('Alamat domisili tempat tinggal saat ini'),
                    ]),

                Section::make('Penugasan & Status Alur Kerja')
                    ->description('Pengelolaan petugas penanggungjawab dan pembaruan alur status')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('officer_id')
                                ->label('Petugas Verifikator')
                                ->relationship('officer', 'name')
                                ->searchable()
                                ->preload()
                                ->default(auth()->id()),
                            Select::make('work_unit_id')
                                ->label('Unit Kerja / Bidang')
                                ->relationship('workUnit', 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('status')
                                ->label('Status Permohonan')
                                ->options(ServiceRequestStatus::class)
                                ->default(ServiceRequestStatus::Submitted)
                                ->required(),
                        ]),
                        Grid::make(2)->schema([
                            Textarea::make('verification_result')
                                ->label('Hasil Verifikasi Dokumen')
                                ->rows(2)
                                ->placeholder('Catatan hasil pengecekan kelengkapan berkas'),
                            Textarea::make('officer_notes')
                                ->label('Catatan Petugas')
                                ->rows(2)
                                ->placeholder('Catatan internal petugas teknis'),
                            Textarea::make('assessment_notes')
                                ->label('Catatan Asesmen Lapangan')
                                ->rows(2)
                                ->placeholder('Hasil kunjungan rumah / asesmen jika diperlukan'),
                            Textarea::make('rejection_reason')
                                ->label('Alasan Penolakan')
                                ->rows(2)
                                ->placeholder('Alasan lengkap bila permohonan ditolak')
                                ->visible(fn (Get $get): bool => in_array($get('status'), [
                                    ServiceRequestStatus::Rejected->value,
                                    ServiceRequestStatus::DocumentsIncomplete->value,
                                ])),
                        ]),
                    ]),
            ]);
    }
}
