<?php

namespace App\Filament\Resources\RehabilitationCases\RelationManagers;

use App\Enums\ReferralStatus;
use App\Models\NumberSequence;
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

class ReferralsRelationManager extends RelationManager
{
    protected static string $relationship = 'referrals';

    protected static ?string $title = 'Rujukan ke Lembaga / Panti / RS';

    protected static ?string $modelLabel = 'Rujukan';

    protected static ?string $pluralModelLabel = 'Rujukan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('referral_number')
                        ->label('Nomor Surat Rujukan')
                        ->default(fn () => NumberSequence::getNextNumber('RUJUK'))
                        ->required(),
                    Select::make('referral_institution_id')
                        ->label('Lembaga Tujuan Rujukan')
                        ->relationship('institution', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    DatePicker::make('referral_date')
                        ->label('Tanggal Rujukan')
                        ->default(now())
                        ->required(),
                    Select::make('status')
                        ->label('Status Rujukan')
                        ->options(ReferralStatus::class)
                        ->default(ReferralStatus::Sent)
                        ->required(),
                    Select::make('officer_id')
                        ->label('Petugas Pendamping')
                        ->relationship('officer', 'name')
                        ->searchable()
                        ->preload()
                        ->default(auth()->id()),
                    DatePicker::make('completed_at')
                        ->label('Tanggal Selesai Pelayanan Rujukan'),
                ]),
                Textarea::make('service_result')
                    ->label('Hasil Pelayanan dari Lembaga Rujukan')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Hasil perkembangan klien selama di panti/RS/balai rujukan'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('referral_number')
            ->defaultSort('referral_date', 'desc')
            ->columns([
                TextColumn::make('referral_number')
                    ->label('No. Rujukan')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('institution.name')
                    ->label('Lembaga Tujuan')
                    ->searchable(),
                TextColumn::make('referral_date')
                    ->label('Tgl Rujukan')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('service_result')
                    ->label('Hasil Rujukan')
                    ->limit(40)
                    ->placeholder('-'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Buat Rujukan Baru'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
