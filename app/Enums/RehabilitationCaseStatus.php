<?php

namespace App\Enums;

enum RehabilitationCaseStatus: string
{
    case Received = 'received';
    case Assessment = 'assessment';
    case ServicePlanning = 'service_planning';
    case InService = 'in_service';
    case Monitoring = 'monitoring';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Received => 'Kasus Diterima',
            self::Assessment => 'Proses Assessment',
            self::ServicePlanning => 'Perencanaan Layanan',
            self::InService => 'Dalam Penanganan',
            self::Monitoring => 'Monitoring Perkembangan',
            self::Closed => 'Kasus Ditutup / Selesai',
        };
    }
}
