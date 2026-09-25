<?php

namespace App\Filament\Resources\ServiceRequests\Schemas;

use App\Models\ServiceRequest;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tiket & Status')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('request_number')
                                ->label('Nomor Tiket')
                                ->weight('bold')
                                ->copyable(),
                            TextEntry::make('serviceType.name')
                                ->label('Jenis Layanan')
                                ->badge()
                                ->color('info'),
                            TextEntry::make('status')
                                ->label('Status Alur')
                                ->badge(),
                            IconEntry::make('is_priority')
                                ->label('Prioritas Tinggi')
                                ->boolean(),
                            TextEntry::make('submitted_at')
                                ->label('Waktu Pengajuan')
                                ->dateTime('d M Y H:i'),
                            TextEntry::make('completed_at')
                                ->label('Waktu Selesai')
                                ->dateTime('d M Y H:i')
                                ->placeholder('-'),
                        ]),
                    ]),

                Section::make('Identitas Pemohon')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('applicant_name')
                                ->label('Nama Lengkap Pemohon')
                                ->weight('bold'),
                            TextEntry::make('applicant_nik')
                                ->label('NIK Pemohon')
                                ->copyable(),
                            TextEntry::make('family_card_number')
                                ->label('No. Kartu Keluarga (KK)'),
                            TextEntry::make('phone')
                                ->label('Nomor Telepon / WhatsApp'),
                            TextEntry::make('village.name')
                                ->label('Desa / Kelurahan'),
                            TextEntry::make('submitter.name')
                                ->label('Akun Pengaju')
                                ->placeholder('-'),
                        ]),
                        TextEntry::make('address')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),
                    ]),

                Section::make('Catatan Petugas & Hasil Layanan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('officer.name')
                                ->label('Petugas Penanggungjawab')
                                ->placeholder('-'),
                            TextEntry::make('workUnit.name')
                                ->label('Unit Kerja / Bidang')
                                ->placeholder('-'),
                        ]),
                        TextEntry::make('verification_result')
                            ->label('Hasil Verifikasi Dokumen')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('officer_notes')
                            ->label('Catatan Petugas')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('assessment_notes')
                            ->label('Catatan Asesmen Lapangan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('service_result')
                            ->label('Hasil Layanan / Surat Rekomendasi')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->placeholder('-')
                            ->columnSpanFull()
                            ->color('danger')
                            ->visible(fn (ServiceRequest $record): bool => filled($record->rejection_reason)),
                    ]),
            ]);
    }
}
