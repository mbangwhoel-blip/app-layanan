<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum HandlingType: string implements HasColor, HasLabel
{
    case Direct = 'direct';
    case Referral = 'referral';
    case Both = 'both';

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Direct => 'info',
            self::Referral => 'warning',
            self::Both => 'primary',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Direct => 'Pelayanan Langsung Dinas Sosial',
            self::Referral => 'Rujukan ke Lembaga Lain',
            self::Both => 'Pelayanan Langsung & Rujukan',
        };
    }
}
