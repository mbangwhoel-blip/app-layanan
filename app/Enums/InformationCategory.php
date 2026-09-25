<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InformationCategory: string implements HasColor, HasLabel
{
    case Program = 'program';
    case Rehabilitation = 'rehabilitation';
    case Disability = 'disability';
    case Elderly = 'elderly';
    case Complaint = 'complaint';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Program => 'primary',
            self::Rehabilitation => 'warning',
            self::Disability => 'info',
            self::Elderly => 'success',
            self::Complaint => 'danger',
            self::Other => 'gray',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Program => 'Program Bantuan Sosial',
            self::Rehabilitation => 'Rehabilitasi Sosial',
            self::Disability => 'Penyandang Disabilitas',
            self::Elderly => 'Lanjut Usia (Lansia)',
            self::Complaint => 'Pengaduan & Bantuan Darurat',
            self::Other => 'Informasi Lainnya',
        };
    }
}
