<?php

namespace App\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use PXP\Exceptions\ValidationException;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        return view('orders.index', [
            'orders' => Order::all(),
        ]);
    }

    public function create(): Response
    {
        return view('orders.create');
    }

    public function store(): Response
    {
        $data = request()->validate(fn ($req) => [
            $req->title->string()->min(3)->max(40),
        ]);

        Order::create(title: $data->title, status: OrderStatus::PLANNED->value);

        return Redirect::route('orders.index');
    }

    public function setStatus(int $id): Response
    {
        $status = request()->int('status');

        if (! in_array($status, OrderStatus::values())) {
            throw new ValidationException('No valid status given');
        }

        Order::find($id)->fill(status: $status)->save();

        return Redirect::route('orders.index');
    }

    public function items(int $id): Response
    {
        $order = Order::find($id);

        return view('orders.items', [
            'order' => $order,
            'items' => $order->items(),
        ]);
    }
}
