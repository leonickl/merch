<?php

namespace App\Models;

use App\Enums\MerchStatus;
use App\Enums\Size;
use PXP\Data\Model;
use PXP\Ds\Vector;

/**
 * @property string $title
 * @property int $sizes
 * @property int $status
 */
class Merch extends Model
{
    protected string $table = 'merchs';

    /**
     * @return Vector<self>
     */
    public static function orderable(): Vector
    {
        return self::all()
            ->filter(fn (self $merch) => $merch->status === MerchStatus::ORDERABLE->value);
    }

    /**
     * @return Vector<Size>
     */
    public function sizes(): Vector
    {
        return Size::separate($this->sizes);
    }

    public function sizesString(): string
    {
        return $this->sizes()->map(fn (Size $size) => $size->label())->join(', ');
    }

    public function status(): MerchStatus
    {
        return MerchStatus::from($this->status);
    }

    public function isOrderable(): bool
    {
        return $this->status === MerchStatus::ORDERABLE->value;
    }
}
