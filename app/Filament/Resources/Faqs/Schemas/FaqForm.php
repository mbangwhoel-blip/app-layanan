<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tanya Jawab (FAQ)')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('information_page_id')
                                ->label('Terkait Halaman Informasi (Opsional)')
                                ->relationship('informationPage', 'title')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih halaman informasi atau biarkan kosong untuk FAQ umum'),
                            TextInput::make('sort_order')
                                ->label('Nomor Urut Tampil')
                                ->numeric()
                                ->default(0),
                        ]),
                        Textarea::make('question')
                            ->label('Pertanyaan')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('Tuliskan pertanyaan yang sering ditanyakan'),
                        Textarea::make('answer')
                            ->label('Jawaban')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Tuliskan jawaban yang komprehensif'),
                        Toggle::make('is_active')
                            ->label('Status Aktif / Ditampilkan di Publik')
                            ->default(true),
                    ]),
            ]);
    }
}
