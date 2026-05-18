<?php

namespace App\Enums;

use PXP\Ds\Vector;

/**
 * Bitmask for sizes
 * Next size should therefor have 4, next 8, and so on
 */
enum Size: int
{
    case XS = 1;
    case S = 2;
    case M = 4;
    case L = 8;
    case XL = 16;

    public function label(): string
    {
        return match ($this) {
            self::XS => 'XS',
            self::S => 'S',
            self::M => 'M',
            self::L => 'L',
            self::XL => 'XL',
        };
    }

    /**
     * @return Vector<self>
     */
    public static function all(): Vector
    {
        return v(...self::cases());
    }

    /**
     * @param  list<self>  $sizes
     */
    public static function combine(array $sizes): int
    {
        $mask = 0;

        foreach ($sizes as $size) {
            $mask |= $size->value;
        }

        return $mask;
    }

    /**
     * @param  list<int|string>  $sizes
     */
    public static function combineValues(array $sizes): int
    {
        return self::combine(array_map(fn ($size) => Size::from((int) $size), $sizes));
    }

    /**
     * @return Vector<self>
     */
    public static function separate(int $sizes): Vector
    {
        return self::all()
            ->filter(fn (self $size) => ($sizes & $size->value) > 0);
    }
}
