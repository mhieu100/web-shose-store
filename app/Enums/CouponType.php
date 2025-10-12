<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CouponType: string implements HasColor, HasIcon, HasLabel
{
    case Percentage = 'percentage';
    case FixedAmount = 'fixed_amount';

    public function getLabel(): string
    {
        return match ($this) {
            self::Percentage => 'Phần trăm (%)',
            self::FixedAmount => 'Số tiền cố định',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Percentage => 'success',
            self::FixedAmount => 'info',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Percentage => 'heroicon-m-percent-badge',
            self::FixedAmount => 'heroicon-m-currency-dollar',
        };
    }
}