<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Aduan Masuk')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('complaint_number')
                                ->label('Nomor Aduan')
                                ->weight('bold')
                                ->copyable(),
                            TextEntry::make('category.name')
                                ->label('Kategori Aduan')
                                ->badge()
                                ->color('warning'),
                            TextEntry::make('status')
                                ->label('Status Penanganan')
                                ->badge(),
                            TextEntry::make('reported_at')
                                ->label('Waktu Dilaporkan')
                                ->dateTime('d M Y H:i'),
                            TextEntry::make('resolved_at')
                                ->label('Waktu Selesai')
                                ->dateTime('d M Y H:i')
                                ->placeholder('Dalam proses'),
                        ]),
                        TextEntry::make('description')
                            ->label('Uraian Lengkap Pengaduan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pelapor & Lokasi Kejadian')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('reporter_name')
                                ->label('Nama Pelapor')
                                ->weight('bold'),
                            TextEntry::make('reporter_phone')
                                ->label('Nomor WhatsApp / HP'),
                            TextEntry::make('village.name')
                                ->label('Desa / Kelurahan'),
                        ]),
                        TextEntry::make('location_detail')
                            ->label('Detail Alamat / Patokan Lokasi')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Tindak Lanjut Petugas')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('officer.name')
                                ->label('Petugas Tindak Lanjut')
                                ->placeholder('-'),
                        ]),
                        TextEntry::make('verification_result')
                            ->label('Hasil Verifikasi Awal')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('action_taken')
                            ->label('Tindakan / Solusi yang Diberikan')
                            ->placeholder('Belum ada tindakan yang dicatat')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
