<?php

namespace App\Filament\Resources\RehabilitationCases\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssessmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assessments';

    protected static ?string $title = 'Riwayat Asesmen Kebutuhan';

    protected static ?string $modelLabel = 'Asesmen';

    protected static ?string $pluralModelLabel = 'Asesmen';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    DatePicker::make('assessment_date')
                        ->label('Tanggal Asesmen')
                        ->default(now())
                        ->required(),
                    Select::make('officer_id')
                        ->label('Petugas Asesor / Pekerja Sosial')
                        ->relationship('officer', 'name')
                        ->searchable()
                        ->preload()
                        ->default(auth()->id())
                        ->required(),
                ]),
                Textarea::make('result')
                    ->label('Hasil Asesmen / Kondisi Klien')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Uraikan kondisi fisik, psikososial, dan ekonomi klien'),
                Textarea::make('service_needs')
                    ->label('Kebutuhan Pelayanan yang Diperlukan')
                    ->rows(2)
                    ->columnSpanFull()
                    ->placeholder('misal: Bantuan alat bantu disabilitas, perawatan panti, terapi medis'),
                Textarea::make('recommendation')
                    ->label('Rekomendasi Rencana Intervensi')
                    ->rows(2)
                    ->columnSpanFull()
                    ->placeholder('Rencana tindakan yang disarankan bagi klien'),
                Toggle::make('needs_referral')
                    ->label('Memerlukan Rujukan ke Lembaga Luar')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('assessment_date')
            ->defaultSort('assessment_date', 'desc')
            ->columns([
                TextColumn::make('assessment_date')
                    ->label('Tgl Asesmen')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('officer.name')
                    ->label('Petugas Asesor')
                    ->searchable(),
                TextColumn::make('result')
                    ->label('Hasil Asesmen')
                    ->limit(50),
                IconColumn::make('needs_referral')
                    ->label('Butuh Rujukan')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Asesmen Baru'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
