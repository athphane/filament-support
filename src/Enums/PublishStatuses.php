<?php

namespace Athphane\FilamentSupport\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum PublishStatuses: string implements HasColor, HasIcon, HasLabel
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::DRAFT => 'dark',
            self::PENDING => 'info',
            self::PUBLISHED => 'success',
            self::REJECTED => 'danger',
        };
    }

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending Review',
            self::PUBLISHED => 'Published',
            self::REJECTED => 'Rejected',
        };
    }

    public function getIcon(): string | BackedEnum | null
    {
        return match ($this) {
            self::DRAFT => Heroicon::OutlinedPencil,
            self::PENDING => Heroicon::OutlinedClock,
            self::PUBLISHED => Heroicon::OutlinedCheckCircle,
            self::REJECTED => Heroicon::OutlinedXCircle,
        };
    }
}
