<?php

namespace App\Enums;

enum Role: int
{
    case REGULAR = 0;
    case ORGA = 1;
    case ADMIN = 2;

    public static function make(int $role): self
    {
        return self::tryFrom($role) ?? self::REGULAR;
    }

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::REGULAR => 'Benutzer:in',
            self::ORGA => 'Organisator:in',
            self::ADMIN => 'Admin',
        };
    }
}
