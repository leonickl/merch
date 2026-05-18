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
}
