<?php

namespace App\Filament\Resources\Complaints\RelationManagers;

use App\Enums\ComplaintAttachmentType;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';

    protected static ?string $title = 'Lampiran Foto & Bukti Aduan';

    protected static ?string $modelLabel = 'Lampiran';

    protected static ?string $pluralModelLabel = 'Lampiran';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Tipe Bukti')
                    ->options(ComplaintAttachmentType::class)
                    ->default(ComplaintAttachmentType::Photo)
                    ->required(),
                FileUpload::make('file_path')
                    ->label('File Foto / Dokumen')
                    ->directory('complaint-attachments')
                    ->visibility('private')
                    ->maxSize(5120)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                    ->required(),
                TextInput::make('original_name')
                    ->label('Keterangan File')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('original_name')
            ->columns([
                TextColumn::make('type')
                    ->label('Tipe Bukti')
                    ->badge(),
                TextColumn::make('original_name')
                    ->label('Nama File / Keterangan')
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Waktu Unggah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Lampiran'),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Lihat / Unduh')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->url(fn ($record) => $record->file_path ? Storage::url($record->file_path) : '#')
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
