<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ServiceRequestStatus: string implements HasColor, HasLabel
{
    case Submitted = 'submitted';
    case DocumentCheck = 'document_check';
    case RevisionRequested = 'revision_requested';
    case DataVerification = 'data_verification';
    case EligibilityVerification = 'eligibility_verification';
    case Verification = 'verification';
    case Assessment = 'assessment';
    case AwaitingApproval = 'awaiting_approval';
    case Issued = 'issued';
    case RecommendationIssued = 'recommendation_issued';
    case ProposedToMinistry = 'proposed_to_ministry';
    case MinistryApproved = 'ministry_approved';
    case MinistryRejected = 'ministry_rejected';
    case Reactivated = 'reactivated';
    case InProcess = 'in_process';
    case Completed = 'completed';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Submitted => 'info',
            self::DocumentCheck, self::DataVerification, self::EligibilityVerification, self::Verification, self::Assessment, self::InProcess => 'warning',
            self::RevisionRequested => 'gray',
            self::AwaitingApproval, self::ProposedToMinistry => 'primary',
            self::Issued, self::RecommendationIssued, self::MinistryApproved, self::Reactivated, self::Completed => 'success',
            self::MinistryRejected, self::Rejected => 'danger',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Submitted => 'Menunggu Verifikasi Berkas',
            self::DocumentCheck => 'Pemeriksaan Berkas',
            self::RevisionRequested => 'Perbaikan Berkas Diminta',
            self::DataVerification => 'Verifikasi Data DTSEN (SIKS-NG)',
            self::EligibilityVerification => 'Verifikasi Kelayakan',
            self::Verification => 'Verifikasi Lapangan / Dokumen',
            self::Assessment => 'Proses Assessment',
            self::AwaitingApproval => 'Menunggu Tanda Tangan / Persetujuan',
            self::Issued => 'Surat Keterangan Diterbitkan',
            self::RecommendationIssued => 'Surat Rekomendasi Diterbitkan',
            self::ProposedToMinistry => 'Diusulkan ke Kemensos (SIKS-NG)',
            self::MinistryApproved => 'Disetujui Kemensos',
            self::MinistryRejected => 'Ditolak Kemensos',
            self::Reactivated => 'Kepesertaan Aktif Kembali (BPJS)',
            self::InProcess => 'Sedang Diproses',
            self::Completed => 'Selesai',
            self::Rejected => 'Ditolak',
        };
    }
}
