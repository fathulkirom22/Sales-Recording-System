<?php

namespace App\Enums;

enum SaleStatus: string
{
    case Unpaid = 'unpaid';
    case PartiallyPaid = 'partially_paid';
    case Paid = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::Unpaid => 'Unpaid',
            self::PartiallyPaid => 'Not Fully Paid',
            self::Paid => 'Paid',
        };
    }

    public function isEditable(): bool
    {
        return $this !== self::Paid;
    }
}
