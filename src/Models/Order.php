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

    public function aggregate(): array
    {
        $groups = [];

        foreach ($this->items() as $item) {
            if (! array_key_exists($item->merch_id, $groups)) {
                $groups[$item->merch_id] = (object) [
                    'merch' => $item->merch(),
                    'sizes' => [],
                ];
            }

            $size = $item->size()?->label() ?? '---';

            if (! array_key_exists($size, $groups[$item->merch_id]->sizes)) {
                $groups[$item->merch_id]->sizes[$size] = 0;
            }

            $groups[$item->merch_id]->sizes[$size]++;
        }

        return $groups;
    }
}
