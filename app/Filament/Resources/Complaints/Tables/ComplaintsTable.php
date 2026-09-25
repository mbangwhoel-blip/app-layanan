<?php

namespace App\Filament\Resources\Complaints\Tables;

use App\Enums\ComplaintStatus;
use App\Enums\HandlingType;
use App\Enums\RehabilitationCaseStatus;
use App\Models\Client;
use App\Models\Complaint;
use App\Models\NumberSequence;
use App\Models\RehabilitationCase;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('reported_at', 'desc')
            ->columns([
                TextColumn::make('complaint_number')
                    ->label('No. Aduan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('warning')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reporter_name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('village.name')
                    ->label('Lokasi Desa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('officer.name')
                    ->label('Petugas')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reported_at')
                    ->label('Tgl Lapor')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('resolved_at')
                    ->label('Tgl Selesai')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(ComplaintStatus::class),
                SelectFilter::make('complaint_category_id')
                    ->label('Filter Kategori')
                    ->relationship('category', 'name'),
                SelectFilter::make('village_id')
                    ->label('Filter Desa')
                    ->relationship('village', 'name'),
                SelectFilter::make('officer_id')
                    ->label('Filter Petugas')
                    ->relationship('officer', 'name'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // 1. Verifikasi Aduan
                Action::make('verify')
                    ->label('Verifikasi Aduan')
                    ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                    ->color('warning')
                    ->visible(fn (Complaint $record): bool => in_array($record->status, [
                        ComplaintStatus::Received,
                        ComplaintStatus::Verification,
                    ]))
                    ->schema([
                        Select::make('status')
                            ->label('Status Hasil Verifikasi')
                            ->options([
                                ComplaintStatus::InHandling->value => 'Valid - Lanjut Penanganan Petugas',
                                ComplaintStatus::ClarificationRequested->value => 'Perlu Klarifikasi Tambahan dari Pelapor',
                                ComplaintStatus::Duplicate->value => 'Aduan Duplikat',
                                ComplaintStatus::Invalid->value => 'Tidak Valid / Laporan Palsu',
                            ])
                            ->required(),
                        Textarea::make('verification_result')
                            ->label('Catatan Hasil Verifikasi Awal')
                            ->required()
                            ->rows(3)
                            ->placeholder('Hasil investigasi awal kebenaran aduan'),
                    ])
                    ->action(function (Complaint $record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                            'verification_result' => $data['verification_result'],
                            'officer_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Verifikasi Aduan Berhasil Disimpan')
                            ->success()
                            ->send();
                    }),

                // 2. Selesaikan Aduan
                Action::make('resolve')
                    ->label('Selesaikan Aduan')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (Complaint $record): bool => ! in_array($record->status, [
                        ComplaintStatus::Resolved,
                        ComplaintStatus::Duplicate,
                        ComplaintStatus::Invalid,
                    ]))
                    ->schema([
                        Textarea::make('action_taken')
                            ->label('Tindakan / Solusi yang Telah Dilakukan')
                            ->required()
                            ->rows(3)
                            ->placeholder('Jelaskan penyelesaian dan intervensi yang telah dilaksanakan'),
                        DatePicker::make('resolved_at')
                            ->label('Tanggal Selesai')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (Complaint $record, array $data): void {
                        $record->update([
                            'status' => ComplaintStatus::Resolved,
                            'action_taken' => $data['action_taken'],
                            'resolved_at' => $data['resolved_at'],
                        ]);

                        Notification::make()
                            ->title('Pengaduan Berhasil Diselesaikan')
                            ->success()
                            ->send();
                    }),

                // 3. Eskalasi ke Kasus Rehabilitasi Sosial
                Action::make('escalate_rehab')
                    ->label('Buat Kasus Rehsos')
                    ->icon(Heroicon::OutlinedHeart)
                    ->color('danger')
                    ->visible(fn (Complaint $record): bool => ! $record->rehabilitationCase()->exists()
                        && in_array($record->status, [
                            ComplaintStatus::Received,
                            ComplaintStatus::Verification,
                            ComplaintStatus::InHandling,
                        ]))
                    ->schema([
                        Select::make('client_id')
                            ->label('Pilih Klien PPKS yang Ditangani')
                            ->options(Client::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Pilih klien PPKS yang terdaftar terkait korban/pemerlu di laporan ini'),
                        Select::make('handling_type')
                            ->label('Tipe Penanganan Awal')
                            ->options(HandlingType::class)
                            ->default(HandlingType::Direct)
                            ->required(),
                    ])
                    ->action(function (Complaint $record, array $data): void {
                        $caseNumber = NumberSequence::getNextNumber('REH');

                        RehabilitationCase::create([
                            'case_number' => $caseNumber,
                            'client_id' => $data['client_id'],
                            'complaint_id' => $record->id,
                            'officer_id' => auth()->id(),
                            'handling_type' => $data['handling_type'],
                            'status' => RehabilitationCaseStatus::Received,
                            'received_at' => now(),
                        ]);

                        $record->update([
                            'status' => ComplaintStatus::InHandling,
                            'action_taken' => "Aduan dieskalasikan ke Kasus Rehabilitasi Sosial No. {$caseNumber}",
                        ]);

                        Notification::make()
                            ->title("Kasus Rehabilitasi {$caseNumber} Berhasil Dibuat dari Aduan")
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
