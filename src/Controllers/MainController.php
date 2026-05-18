<?php

namespace App\Controllers;

use App\Models\Order;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Response;

class MainController extends Controller
{
    public function index(): Response
    {
        return view('main', [
            'orders' => Order::all()
                ->filter(fn (Order $order) => $order->isOpen()),
        ]);
    }
}
