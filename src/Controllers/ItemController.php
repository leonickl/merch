<?php

namespace App\Controllers;

use App\Enums\Size;
use App\Models\Item;
use App\Models\Merch;
use App\Models\Order;
use PXP\Auth\Auth;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;
use PXP\Lib\Notification;

class ItemController extends Controller
{
    public function create(int $id): Response
    {
        $available_sizes = [];

        foreach (Merch::orderable() as $merch) {
            $available_sizes[$merch->id] = $merch->sizes;
        }

        return view('items.create', [
            'order_id' => $id,
            'merchs' => Merch::orderable(),
            'sizes' => Size::all(),
            'available_sizes' => $available_sizes,
        ]);
    }

    public function store(int $id): Response
    {
        $order = Order::find($id);
        $merch = Merch::findOrNull(request()->int('merch'));
        $size = Size::tryFrom(request()->int('size'));

        if ($merch === null) {
            Notification::warn('Bitte Merch auswählen.');

            return Redirect::path(route('items.create', id: $order->id));
        }

        if (! $order->isOpen()) {
            Notification::warn('Diese Bestellung ist momentan geschlossen.');

            return Redirect::path(route('main'));
        }

        if (! $merch->isOrderable()) {
            Notification::warn('Dieser Merch ist momentan nicht bestellbar.');

            return Redirect::path(route('items.create', id: $order->id));
        }

        if ($merch->sizes > 0 && $size === null) {
            Notification::warn('Bitte eine Größe angeben.');

            return Redirect::path(route('items.create', id: $order->id));
        }

        if ($merch->sizes > 0 && ! ($merch->sizes & $size->value)) {
            Notification::warn('Bitte eine vorhandene Größe angeben.');

            return Redirect::path(route('items.create', id: $order->id));
        }

        Item::create(
            order_id: $order->id,
            user_id: Auth::user()?->id,
            merch_id: $merch->id,
            size: $size?->value ?? 0,
        );

        $size_label = 'in Größe '.$size?->label() ?? '';

        Notification::success("Du hast erfolgreich '$merch->title' $size_label bestellt.");

        return Redirect::path(route('items.create', id: $order->id));
    }
}
