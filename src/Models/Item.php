<?php

namespace App\Models;

use App\Enums\Size;
use Carbon\Carbon;
use PXP\Data\Model;
use PXP\Auth\Models\User;
use PXP\Auth\Auth;
use PXP\Ds\Vector;

/**
 * @property int $order_id
 * @property int $user_id
 * @property int $merch_id
 * @property int $size
 */
class Item extends Model
{
    protected string $table = 'items';

    public function order(): Order
    {
        return Order::find($this->order_id);
    }

    public function user(): User
    {
        return User::find($this->user_id);
    }

    public function merch(): Merch
    {
        return Merch::find($this->merch_id);
    }

    public function size(): ?Size
    {
        return Size::tryFrom($this->size);
    }

    public function createdAt(): string
    {
        return new Carbon($this->created_at)->format('d.m.Y H:i');
    }

    public static function mine(): Vector
    {
        return Item::findAllBy('user_id', Auth::user()?->id);
    }

    public function canCancel(): bool
    {
        return $this->order()->isOpen();
    }
}
