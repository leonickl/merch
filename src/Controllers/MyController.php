<?php

namespace App\Controllers;

use PXP\Http\Controllers\Controller;
use App\Models\Item;

class MyController extends Controller
{
    public function index()
    {
        return view('my', [
            'items' => Item::mine(),
        ]);
    }
}