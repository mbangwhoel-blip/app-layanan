<?php

namespace App\Filament\Resources\ServiceRequests\RelationManagers;

use App\Enums\DocumentVerificationStatus;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ServiceRequestDocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Dokumen Persyaratan Pemohon';

    protected static ?string $modelLabel = 'Dokumen';

    protected static ?string $pluralModelLabel = 'Dokumen';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_requirement_id')
                    ->label('Jenis Persyaratan')
                    ->relationship('serviceRequirement', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                FileUpload::make('file_path')
                    ->label('Berkas Dokumen')
                    ->directory('service-documents')
                    ->visibility('private')
                    ->maxSize(5120)
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->required(),
                TextInput::make('original_name')
                    ->label('Nama Asli File')
                    ->maxLength(255),
                Select::make('verification_status')
                    ->label('Status Verifikasi')
                    ->options(DocumentVerificationStatus::class)
                    ->default(DocumentVerificationStatus::Pending)
                    ->required(),
                Textarea::make('notes')
                    ->label('Catatan Verifikasi Berkas')
                    ->rows(2)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_name')
            ->columns([
                TextColumn::make('serviceRequirement.name')
                    ->label('Persyaratan Dokumen')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('original_name')
                    ->label('Nama File')
                    ->searchable(),
                TextColumn::make('verification_status')
                    ->label('Status Verifikasi')
                    ->badge(),
                TextColumn::make('notes')
                    ->label('Catatan Petugas')
                    ->placeholder('-')
                    ->limit(40),
                TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Unggah Dokumen'),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Unduh')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->url(fn ($record) => $record->file_path ? Storage::url($record->file_path) : '#')
                    ->openUrlInNewTab(),
                Action::make('verify')
                    ->label('Verifikasi')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->schema([
                        Select::make('verification_status')
                            ->label('Hasil Verifikasi Dokumen')
                            ->options(DocumentVerificationStatus::class)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Catatan / Keterangan (Alasan bila tidak sah)'),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update($data);
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
