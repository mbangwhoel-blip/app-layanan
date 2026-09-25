<?php

namespace App\Filament\Resources\RehabilitationCases\Schemas;

use App\Enums\HandlingType;
use App\Enums\RehabilitationCaseStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RehabilitationCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Registrasi Kasus')
                    ->description('Nomor kasus dan klien yang ditangani')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('case_number')
                                ->label('Nomor Kasus')
                                ->placeholder('Dibuat otomatis oleh sistem')
                                ->disabled()
                                ->dehydrated(false),
                            Select::make('client_id')
                                ->label('Klien / PPKS')
                                ->relationship('client', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            DateTimePicker::make('received_at')
                                ->label('Waktu Kasus Diterima')
                                ->default(now()),
                        ]),
                    ]),

                Section::make('Rencana Penanganan & Sumber Rujukan')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('handling_type')
                                ->label('Tipe Penanganan')
                                ->options(HandlingType::class)
                                ->default(HandlingType::Direct)
                                ->required(),
                            Select::make('officer_id')
                                ->label('Pekerja Sosial / Petugas Pendamping')
                                ->relationship('officer', 'name')
                                ->searchable()
                                ->preload()
                                ->default(auth()->id()),
                            Select::make('service_request_id')
                                ->label('Terkait Permohonan Layanan (Jika Ada)')
                                ->relationship('serviceRequest', 'request_number')
                                ->searchable()
                                ->preload(),
                            Select::make('complaint_id')
                                ->label('Terkait Aduan Masyarakat (Jika Ada)')
                                ->relationship('complaint', 'ticket_number')
                                ->searchable()
                                ->preload(),
                        ]),
                    ]),

                Section::make('Status Penanganan & Hasil Terminasi')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('Status Kasus')
                                ->options(RehabilitationCaseStatus::class)
                                ->default(RehabilitationCaseStatus::Received)
                                ->required(),
                            DateTimePicker::make('closed_at')
                                ->label('Waktu Kasus Ditutup / Selesai'),
                        ]),
                        Textarea::make('handling_result')
                            ->label('Hasil Penanganan / Catatan Terminasi Kasus')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Uraian kondisi akhir klien saat kasus ditutup atau hasil rujukan'),
                    ]),
            ]);
    }
}
