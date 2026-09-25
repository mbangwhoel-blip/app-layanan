<?php

namespace App\Filament\Resources\RehabilitationCases\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RehabilitationCaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kasus & Klien')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('case_number')
                                ->label('Nomor Kasus')
                                ->weight('bold')
                                ->copyable(),
                            TextEntry::make('client.name')
                                ->label('Nama Klien / PPKS')
                                ->weight('bold'),
                            TextEntry::make('client.category.name')
                                ->label('Kategori PPKS')
                                ->badge()
                                ->color('info'),
                            TextEntry::make('handling_type')
                                ->label('Tipe Penanganan')
                                ->badge(),
                            TextEntry::make('status')
                                ->label('Status Kasus')
                                ->badge(),
                            TextEntry::make('officer.name')
                                ->label('Peksos / Pendamping')
                                ->placeholder('-'),
                            TextEntry::make('received_at')
                                ->label('Waktu Kasus Diterima')
                                ->dateTime('d M Y H:i'),
                            TextEntry::make('closed_at')
                                ->label('Waktu Kasus Selesai')
                                ->dateTime('d M Y H:i')
                                ->placeholder('Masih berjalan'),
                        ]),
                    ]),

                Section::make('Hasil Penanganan & Terminasi')
                    ->schema([
                        TextEntry::make('handling_result')
                            ->label('Uraian Hasil Akhir / Kondisi Terminasi')
                            ->placeholder('Belum ada catatan hasil terminasi')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
