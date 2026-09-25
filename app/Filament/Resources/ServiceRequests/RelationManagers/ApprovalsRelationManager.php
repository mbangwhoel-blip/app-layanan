<?php

namespace App\Filament\Resources\ServiceRequests\RelationManagers;

use App\Enums\ApprovalDecision;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApprovalsRelationManager extends RelationManager
{
    protected static string $relationship = 'approvals';

    protected static ?string $title = 'Riwayat Persetujuan Berjenjang';

    protected static ?string $modelLabel = 'Persetujuan';

    protected static ?string $pluralModelLabel = 'Persetujuan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('step')
                    ->label('Tahap Persetujuan')
                    ->numeric()
                    ->default(1)
                    ->required(),
                Select::make('approver_id')
                    ->label('Pejabat Penandatangan / Pemeriksa')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->preload()
                    ->default(auth()->id())
                    ->required(),
                Select::make('decision')
                    ->label('Keputusan')
                    ->options(ApprovalDecision::class)
                    ->required(),
                DateTimePicker::make('decided_at')
                    ->label('Waktu Keputusan')
                    ->default(now())
                    ->required(),
                Textarea::make('notes')
                    ->label('Catatan / Instruksi Disposisi')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('decision')
            ->defaultSort('step', 'asc')
            ->columns([
                TextColumn::make('step')
                    ->label('Tahap')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('approver.name')
                    ->label('Pejabat / Penelaah')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('decision')
                    ->label('Keputusan')
                    ->badge(),
                TextColumn::make('decided_at')
                    ->label('Tanggal Keputusan')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Menunggu'),
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(50),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Persetujuan'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
