<?php

namespace App\Filament\Resources\ServiceRequests\Tables;

use App\Enums\ApprovalDecision;
use App\Enums\MinistryDecision;
use App\Enums\ServiceRequestStatus;
use App\Models\Approval;
use App\Models\DtsenCertificate;
use App\Models\NumberSequence;
use App\Models\ServiceRequest;
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
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('submitted_at', 'desc')
            ->columns([
                TextColumn::make('request_number')
                    ->label('No. Tiket')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('serviceType.name')
                    ->label('Jenis Layanan')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('applicant_name')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('applicant_nik')
                    ->label('NIK')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('village.name')
                    ->label('Desa/Kelurahan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status Alur')
                    ->badge()
                    ->sortable(),
                IconColumn::make('is_priority')
                    ->label('Prioritas')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('officer.name')
                    ->label('Petugas')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('submitted_at')
                    ->label('Tgl Diajukan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->label('Selesai Pada')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(ServiceRequestStatus::class),
                SelectFilter::make('service_type_id')
                    ->label('Filter Jenis Layanan')
                    ->relationship('serviceType', 'name'),
                SelectFilter::make('village_id')
                    ->label('Filter Wilayah Desa')
                    ->relationship('village', 'name'),
                TernaryFilter::make('is_priority')
                    ->label('Status Prioritas'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // 1. Verifikasi Berkas (Petugas Dinsos)
                Action::make('verify')
                    ->label('Verifikasi Berkas')
                    ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                    ->color('warning')
                    ->visible(fn (ServiceRequest $record): bool => in_array($record->status, [
                        ServiceRequestStatus::Submitted,
                        ServiceRequestStatus::DocumentCheck,
                        ServiceRequestStatus::RevisionRequested,
                    ]))
                    ->schema([
                        Select::make('status')
                            ->label('Hasil Verifikasi Berkas')
                            ->options([
                                ServiceRequestStatus::DataVerification->value => 'Data Lengkap - Verifikasi SIKS-NG',
                                ServiceRequestStatus::Verification->value => 'Lolos Verifikasi Administrasi',
                                ServiceRequestStatus::RevisionRequested->value => 'Berkas Belum Lengkap (Minta Perbaikan)',
                                ServiceRequestStatus::Rejected->value => 'Tolak Permohonan',
                            ])
                            ->required(),
                        Textarea::make('verification_result')
                            ->label('Catatan Hasil Verifikasi')
                            ->required()
                            ->rows(3)
                            ->placeholder('Jelaskan kelengkapan dokumen atau bagian berkas yang kurang'),
                    ])
                    ->action(function (ServiceRequest $record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                            'verification_result' => $data['verification_result'],
                            'officer_id' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Verifikasi Berkas Berhasil Disimpan')
                            ->success()
                            ->send();
                    }),

                // 2. Persetujuan Pejabat Penandatangan
                Action::make('approve_official')
                    ->label('Tanda Tangan / Setujui')
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->color('success')
                    ->visible(fn (ServiceRequest $record): bool => in_array($record->status, [
                        ServiceRequestStatus::AwaitingApproval,
                        ServiceRequestStatus::DataVerification,
                        ServiceRequestStatus::Verification,
                    ]))
                    ->schema([
                        Select::make('decision')
                            ->label('Keputusan Pejabat')
                            ->options(ApprovalDecision::class)
                            ->default(ApprovalDecision::Approved)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Catatan / Keterangan Persetujuan')
                            ->rows(2),
                    ])
                    ->action(function (ServiceRequest $record, array $data): void {
                        // Record Approval
                        Approval::create([
                            'approvable_type' => ServiceRequest::class,
                            'approvable_id' => $record->id,
                            'step' => 1,
                            'approver_id' => auth()->id(),
                            'decision' => $data['decision'],
                            'notes' => $data['notes'] ?? null,
                            'decided_at' => now(),
                        ]);

                        $newStatus = match ($data['decision']) {
                            ApprovalDecision::Approved => ServiceRequestStatus::Issued,
                            ApprovalDecision::Rejected => ServiceRequestStatus::Rejected,
                            ApprovalDecision::Revision => ServiceRequestStatus::RevisionRequested,
                            default => $record->status,
                        };

                        $record->update(['status' => $newStatus]);

                        Notification::make()
                            ->title('Persetujuan Pejabat Dicatat')
                            ->success()
                            ->send();
                    }),

                // 3. Penerbitan Surat Keterangan Terdaftar DTSEN
                Action::make('issue_dtsen')
                    ->label('Terbitkan Surat DTSEN')
                    ->icon(Heroicon::OutlinedDocumentCheck)
                    ->color('success')
                    ->visible(fn (ServiceRequest $record): bool => $record->serviceType?->code === 'DTSEN'
                        && in_array($record->status, [
                            ServiceRequestStatus::Issued,
                            ServiceRequestStatus::DataVerification,
                            ServiceRequestStatus::Verification,
                        ]))
                    ->schema([
                        TextInput::make('decile')
                            ->label('Desil Terdaftar (1 - 10)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->required()
                            ->helperText('Berdasarkan hasil pengecekan basis data DTSEN'),
                        Select::make('dtsen_purpose_id')
                            ->label('Tujuan Keperluan')
                            ->relationship('dtsenCertificate.dtsenPurpose', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('purpose_description')
                            ->label('Keterangan Keperluan Tambahan')
                            ->placeholder('misal: Rekomendasi beasiswa kuliah semester 1'),
                        DatePicker::make('valid_until')
                            ->label('Masa Berlaku Surat Hingga')
                            ->default(now()->addDays(30))
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data): void {
                        $certNumber = NumberSequence::getNextNumber('460/DTSEN');
                        $verificationCode = strtoupper(Str::random(12));

                        DtsenCertificate::updateOrCreate(
                            ['service_request_id' => $record->id],
                            [
                                'dtsen_purpose_id' => $data['dtsen_purpose_id'],
                                'purpose_description' => $data['purpose_description'] ?? null,
                                'subject_name' => $record->applicant_name,
                                'subject_nik' => $record->applicant_nik,
                                'relationship_to_applicant' => 'Diri Sendiri',
                                'is_registered' => true,
                                'decile' => $data['decile'],
                                'checked_at' => now(),
                                'checker_id' => auth()->id(),
                                'certificate_number' => $certNumber,
                                'issued_at' => now(),
                                'valid_until' => $data['valid_until'],
                                'signer_id' => auth()->id(),
                                'verification_code' => $verificationCode,
                            ]
                        );

                        $record->update([
                            'status' => ServiceRequestStatus::Completed,
                            'completed_at' => now(),
                            'service_result' => "Surat Rekomendasi Terdaftar DTSEN No. {$certNumber} telah diterbitkan.",
                        ]);

                        Notification::make()
                            ->title("Surat Rekomendasi {$certNumber} Berhasil Diterbitkan")
                            ->success()
                            ->send();
                    }),

                // 4. Usulkan PBI-JK ke Kemensos
                Action::make('submit_pbi')
                    ->label('Usulkan ke Kemensos')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('primary')
                    ->visible(fn (ServiceRequest $record): bool => $record->serviceType?->code === 'PBI_JK'
                        && in_array($record->status, [
                            ServiceRequestStatus::Issued,
                            ServiceRequestStatus::RecommendationIssued,
                            ServiceRequestStatus::Verification,
                        ]))
                    ->schema([
                        DatePicker::make('proposed_at')
                            ->label('Tanggal Pengusulan via SIKS-NG')
                            ->default(now())
                            ->required(),
                        Textarea::make('officer_notes')
                            ->label('Catatan Pengusulan SIKS-NG')
                            ->rows(2),
                    ])
                    ->action(function (ServiceRequest $record, array $data): void {
                        $record->pbiReactivation?->update([
                            'proposed_to_ministry_at' => $data['proposed_at'],
                        ]);

                        $record->update([
                            'status' => ServiceRequestStatus::ProposedToMinistry,
                            'officer_notes' => $data['officer_notes'] ?? $record->officer_notes,
                        ]);

                        Notification::make()
                            ->title('Status Berhasil Diperbarui: Diusulkan ke Kemensos')
                            ->success()
                            ->send();
                    }),

                // 5. Keputusan Kemensos (PBI-JK)
                Action::make('pbi_decision')
                    ->label('Hasil Putusan Kemensos')
                    ->icon(Heroicon::OutlinedArrowPath)
                    ->color('info')
                    ->visible(fn (ServiceRequest $record): bool => $record->serviceType?->code === 'PBI_JK'
                        && $record->status === ServiceRequestStatus::ProposedToMinistry)
                    ->schema([
                        Select::make('ministry_decision')
                            ->label('Keputusan Kemensos RI')
                            ->options(MinistryDecision::class)
                            ->required(),
                        DatePicker::make('reactivated_date')
                            ->label('Tanggal Reaktivasi Aktif Kembali (Jika Disetujui)')
                            ->default(now()),
                        Textarea::make('service_result')
                            ->label('Catatan Hasil / Keterangan'),
                    ])
                    ->action(function (ServiceRequest $record, array $data): void {
                        $isApproved = ($data['ministry_decision'] === MinistryDecision::Approved || $data['ministry_decision'] === 'approved');

                        $record->pbiReactivation?->update([
                            'ministry_decision' => $data['ministry_decision'],
                            'ministry_decided_at' => now(),
                            'reactivated_date' => $isApproved ? $data['reactivated_date'] : null,
                        ]);

                        $newStatus = $isApproved ? ServiceRequestStatus::Reactivated : ServiceRequestStatus::MinistryRejected;

                        $record->update([
                            'status' => $newStatus,
                            'completed_at' => now(),
                            'service_result' => $data['service_result'] ?? ($isApproved ? 'Kepesertaan PBI-JK telah aktif kembali' : 'Pengusulan reaktivasi ditolak oleh Kemensos'),
                        ]);

                        Notification::make()
                            ->title('Hasil Putusan Kemensos Berhasil Dicatat')
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
