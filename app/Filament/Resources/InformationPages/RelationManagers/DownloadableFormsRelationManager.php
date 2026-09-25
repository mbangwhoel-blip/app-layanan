<?php

namespace App\Filament\Resources\InformationPages\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DownloadableFormsRelationManager extends RelationManager
{
    protected static string $relationship = 'downloadableForms';

    protected static ?string $title = 'Formulir Unduhan & Blanko';

    protected static ?string $modelLabel = 'Formulir Unduhan';

    protected static ?string $pluralModelLabel = 'Formulir Unduhan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Formulir / Dokumen')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('contoh: Blanko Surat Pernyataan Tanggung Jawab Mutlak (SPTJM)'),
                TextInput::make('version')
                    ->label('Versi Formulir')
                    ->default('v1.0')
                    ->maxLength(20),
                FileUpload::make('file_path')
                    ->label('File Formulir (PDF / Word / Excel)')
                    ->directory('downloadable-forms')
                    ->visibility('public')
                    ->maxSize(10240)
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->required(),
                Toggle::make('is_current')
                    ->label('Versi Berlaku Saat Ini')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Formulir')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('version')
                    ->label('Versi')
                    ->badge()
                    ->color('gray'),
                IconColumn::make('is_current')
                    ->label('Berlaku')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Formulir'),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Unduh')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->url(fn ($record) => $record->file_path ? Storage::url($record->file_path) : '#')
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
