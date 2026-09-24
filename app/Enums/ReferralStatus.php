<?php

namespace App\Enums;

enum ReferralStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case InService = 'in_service';
    case Completed = 'completed';
    case Declined = 'declined';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draf Rujukan',
            self::Sent => 'Rujukan Dikirim',
            self::Accepted => 'Diterima Lembaga Rujukan',
            self::InService => 'Dalam Pelayanan Lembaga',
            self::Completed => 'Pelayanan Selesai',
            self::Declined => 'Ditolak Lembaga',
            self::Cancelled => 'Dibatalkan',
        };
    }
}
