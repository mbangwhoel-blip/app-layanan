<?php

namespace App\Filament\Resources\RehabilitationCases\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MonitoringRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'monitoringRecords';

    protected static ?string $title = 'Catatan Monitoring & Perkembangan';

    protected static ?string $modelLabel = 'Catatan Monitoring';

    protected static ?string $pluralModelLabel = 'Catatan Monitoring';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    DatePicker::make('monitoring_date')
                        ->label('Tanggal Kunjungan / Monitoring')
                        ->default(now())
                        ->required(),
                    Select::make('officer_id')
                        ->label('Petugas Monitoring')
                        ->relationship('officer', 'name')
                        ->searchable()
                        ->preload()
                        ->default(auth()->id())
                        ->required(),
                    TextInput::make('progress')
                        ->label('Ringkasan Perkembangan Klien')
                        ->placeholder('misal: Kondisi stabil, mandiri beraktivitas, atau butuh obat lanjutan')
                        ->columnSpanFull()
                        ->required(),
                ]),
                Textarea::make('result_notes')
                    ->label('Uraian Catatan Evaluasi & Rencana Lanjutan')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Catatan detail hasil pengamatan langsung kondisi klien dan keluarga'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('monitoring_date')
            ->defaultSort('monitoring_date', 'desc')
            ->columns([
                TextColumn::make('monitoring_date')
                    ->label('Tgl Monitoring')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('officer.name')
                    ->label('Petugas')
                    ->searchable(),
                TextColumn::make('progress')
                    ->label('Perkembangan')
                    ->limit(50)
                    ->weight('bold'),
                TextColumn::make('result_notes')
                    ->label('Catatan Evaluasi')
                    ->limit(40)
                    ->placeholder('-'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Catatan Monitoring'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
