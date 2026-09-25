<?php

namespace App\Filament\Resources\ServiceTypes\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceRequirementsRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceRequirements';

    protected static ?string $title = 'Dokumen Persyaratan Layanan';

    protected static ?string $modelLabel = 'Persyaratan';

    protected static ?string $pluralModelLabel = 'Persyaratan Dokumen';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Dokumen Persyaratan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('contoh: Surat Pengantar RT/RW atau Surat Keterangan Tidak Mampu (SKTM)'),
                Toggle::make('is_mandatory')
                    ->label('Wajib Diunggah')
                    ->default(true),
                TextInput::make('allowed_mimes')
                    ->label('Format File Diizinkan')
                    ->default('pdf,jpg,jpeg,png')
                    ->required()
                    ->helperText('Format ekstensi dipisah tanda koma, contoh: pdf,jpg,jpeg,png'),
                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('sort_order', 'asc')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('No / Urut')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Persyaratan')
                    ->searchable()
                    ->weight('bold'),
                IconColumn::make('is_mandatory')
                    ->label('Wajib')
                    ->boolean(),
                TextColumn::make('allowed_mimes')
                    ->label('Format Diizinkan')
                    ->badge()
                    ->color('gray'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Persyaratan'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
