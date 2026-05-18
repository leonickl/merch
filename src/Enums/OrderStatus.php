<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PLANNED = 0;
    case OPEN = 1;
    case CLOSED = 2;

    public function label(): string
    {
        return match ($this) {
            self::PLANNED => 'In Planung',
            self::OPEN => 'Geöffnet',
            self::CLOSED => 'Geschlossen',
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }
}
