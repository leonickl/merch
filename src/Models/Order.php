<?php

namespace App\Models;

use App\Enums\OrderStatus;
use PXP\Data\Model;
use PXP\Ds\Vector;

/**
 * @property string $title
 * @property int $status
 */
class Order extends Model
{
    protected string $table = 'orders';

    public function status(): OrderStatus
    {
        return OrderStatus::from($this->status);
    }

    public function isOpen(): bool
    {
        return $this->status === OrderStatus::OPEN->value;
    }

    /**
     * @return Vector<Item>
     */
    public function items(): Vector
    {
        return Item::all()->filter(fn (Item $item) => $item->order_id === $this->id);
    }
}
