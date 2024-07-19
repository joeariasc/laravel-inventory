<?php

namespace App\Enums;

enum SupplierType: int
{
    case DISTRIBUTOR = 1;

    case WHOLESALER = 2;

    case PRODUCER = 3;

    public function label(): string
    {
        return match ($this) {
            self::DISTRIBUTOR => __('Distributor'),
            self::WHOLESALER => __('Wholesaler'),
            self::PRODUCER => __('Producer'),
        };
    }
}
