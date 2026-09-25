<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RehabilitationCaseStatus: string implements HasColor, HasLabel
{
    case Received = 'received';
    case Assessment = 'assessment';
    case ServicePlanning = 'service_planning';
    case InService = 'in_service';
    case Monitoring = 'monitoring';
    case Closed = 'closed';

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Received => 'info',
            self::Assessment, self::ServicePlanning => 'warning',
            self::InService, self::Monitoring => 'primary',
            self::Closed => 'success',
        };
    }

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
