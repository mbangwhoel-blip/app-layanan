<?php

namespace App\Enums;

enum HandlingType: string
{
    case Direct = 'direct';
    case Referral = 'referral';
    case Both = 'both';

    public function label(): string
    {
        return match ($this) {
            self::Direct => 'Pelayanan Langsung Dinas Sosial',
            self::Referral => 'Rujukan ke Lembaga Lain',
            self::Both => 'Pelayanan Langsung & Rujukan',
        };
    }
}
