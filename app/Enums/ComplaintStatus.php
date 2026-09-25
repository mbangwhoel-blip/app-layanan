<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ComplaintStatus: string implements HasColor, HasLabel
{
    case Received = 'received';
    case Verification = 'verification';
    case ClarificationRequested = 'clarification_requested';
    case Dispatched = 'dispatched';
    case InHandling = 'in_handling';
    case Resolved = 'resolved';
    case Duplicate = 'duplicate';
    case Invalid = 'invalid';

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Received => 'info',
            self::Verification, self::ClarificationRequested => 'warning',
            self::Dispatched, self::InHandling => 'primary',
            self::Resolved => 'success',
            self::Duplicate, self::Invalid => 'danger',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Received => 'Laporan Diterima',
            self::Verification => 'Verifikasi Awal',
            self::ClarificationRequested => 'Menunggu Klarifikasi Pelapor',
            self::Dispatched => 'Didisposisikan ke Petugas/Unit',
            self::InHandling => 'Sedang Ditangani',
            self::Resolved => 'Selesai Ditangani',
            self::Duplicate => 'Laporan Duplikat',
            self::Invalid => 'Tidak Valid / Ditolak',
        };
    }
}
