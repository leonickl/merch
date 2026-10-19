<?php

namespace App\Controllers;

use App\Models\Order;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Response;
use App\Enums\OrderStatus;

class MainController extends Controller
{
    public function index(): Response
    {
        return view('main', [
            'order' => Order::findByOrNull('status', OrderStatus::OPEN->value),
        ]);
    }
}
