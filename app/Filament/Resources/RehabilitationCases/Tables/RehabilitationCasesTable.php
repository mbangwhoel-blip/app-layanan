<?php

namespace App\Filament\Resources\RehabilitationCases\Tables;

use App\Enums\HandlingType;
use App\Enums\ReferralStatus;
use App\Enums\RehabilitationCaseStatus;
use App\Models\NumberSequence;
use App\Models\Referral;
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

class RehabilitationCasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('received_at', 'desc')
            ->columns([
                TextColumn::make('case_number')
                    ->label('No. Kasus')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('client.name')
                    ->label('Nama Klien / PPKS')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('client.category.name')
                    ->label('Kategori PPKS')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('handling_type')
                    ->label('Tipe Penanganan')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status Kasus')
                    ->badge()
                    ->sortable(),
                TextColumn::make('officer.name')
                    ->label('Peksos / Pendamping')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('assessments_count')
                    ->counts('assessments')
                    ->label('Asesmen')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('referrals_count')
                    ->counts('referrals')
                    ->label('Rujukan')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('received_at')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('closed_at')
                    ->label('Tgl Selesai')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(RehabilitationCaseStatus::class),
                SelectFilter::make('handling_type')
                    ->label('Filter Tipe Penanganan')
                    ->options(HandlingType::class),
                SelectFilter::make('officer_id')
                    ->label('Filter Petugas')
                    ->relationship('officer', 'name'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // 1. Mulai Penanganan
                Action::make('start_service')
                    ->label('Mulai Penanganan')
                    ->icon(Heroicon::OutlinedPlay)
                    ->color('primary')
                    ->visible(fn (RehabilitationCase $record): bool => in_array($record->status, [
                        RehabilitationCaseStatus::Received,
                        RehabilitationCaseStatus::Assessment,
                        RehabilitationCaseStatus::ServicePlanning,
                    ]))
                    ->action(function (RehabilitationCase $record): void {
                        $record->update(['status' => RehabilitationCaseStatus::InService]);

                        Notification::make()
                            ->title('Status Berhasil Diubah: Dalam Penanganan')
                            ->success()
                            ->send();
                    }),

                // 2. Rujuk ke Lembaga Luar
                Action::make('refer')
                    ->label('Rujuk ke Lembaga')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('warning')
                    ->visible(fn (RehabilitationCase $record): bool => $record->status !== RehabilitationCaseStatus::Closed)
                    ->schema([
                        Select::make('referral_institution_id')
                            ->label('Pilih Lembaga / Panti / RS Rujukan')
                            ->relationship('referrals.institution', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        DatePicker::make('referral_date')
                            ->label('Tanggal Rujukan')
                            ->default(now())
                            ->required(),
                        Textarea::make('notes')
                            ->label('Catatan Kebutuhan Pelayanan Rujukan')
                            ->rows(3)
                            ->required(),
                    ])
                    ->action(function (RehabilitationCase $record, array $data): void {
                        $refNumber = NumberSequence::getNextNumber('RUJUK');

                        Referral::create([
                            'referral_number' => $refNumber,
                            'rehabilitation_case_id' => $record->id,
                            'referral_institution_id' => $data['referral_institution_id'],
                            'officer_id' => auth()->id(),
                            'referral_date' => $data['referral_date'],
                            'status' => ReferralStatus::Sent,
                            'service_result' => $data['notes'],
                        ]);

                        $record->update([
                            'handling_type' => HandlingType::Referral,
                            'status' => RehabilitationCaseStatus::InService,
                        ]);

                        Notification::make()
                            ->title("Rujukan {$refNumber} Berhasil Dibuat")
                            ->success()
                            ->send();
                    }),

                // 3. Selesaikan / Tutup Kasus
                Action::make('close_case')
                    ->label('Tutup Kasus')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (RehabilitationCase $record): bool => $record->status !== RehabilitationCaseStatus::Closed)
                    ->schema([
                        DatePicker::make('closed_at')
                            ->label('Tanggal Selesai / Kasus Ditutup')
                            ->default(now())
                            ->required(),
                        Textarea::make('handling_result')
                            ->label('Hasil Akhir / Alasan Penutupan Kasus')
                            ->rows(3)
                            ->required()
                            ->placeholder('misal: Klien telah mandiri, reunifikasi dengan keluarga, atau sembuh dari rehabilitasi'),
                    ])
                    ->action(function (RehabilitationCase $record, array $data): void {
                        $record->update([
                            'status' => RehabilitationCaseStatus::Closed,
                            'closed_at' => $data['closed_at'],
                            'handling_result' => $data['handling_result'],
                        ]);

                        Notification::make()
                            ->title('Kasus Rehabilitasi Berhasil Ditutup')
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
