<?php

namespace App\Controllers;

use App\Models\User;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return view('users.index');
    }

    public function create(): Response
    {
        return view('users.create');
    }

    public function store(): Response
    {
        User::create();

        return Redirect::route('users.index');
    }
}
