<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ComplaintAttachmentType: string implements HasColor, HasLabel
{
    case Photo = 'photo';
    case Document = 'document';

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Photo => 'info',
            self::Document => 'warning',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Photo => 'Foto / Bukti Gambar',
            self::Document => 'Dokumen / Surat Keterangan',
        };
    }
}
