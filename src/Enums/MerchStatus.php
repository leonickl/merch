<?php

namespace App\Enums;

enum MerchStatus: int
{
    case UNAVAILABLE = 0;
    case ORDERABLE = 1;

    public function label(): string
    {
        return match ($this) {
            self::UNAVAILABLE => 'Nicht verfügbar',
            self::ORDERABLE => 'Bestellbar',
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }
}
