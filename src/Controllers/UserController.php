<?php

namespace App\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Notification;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;
use PXP\Lib\Auth;

class UserController extends Controller
{
    public function index(): Response
    {
        return view('users.index', [
            'users' => User::all(),
        ]);
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

    public function setRole(int $id): Response
    {
        $role = request()->int('role');

        if (! in_array($role, Role::values())) {
            throw new ValidationException('No valid role given');
        }

        if ($id === Auth::user()?->id) {
            Notification::warn('Du kannst dich nicht selbst umstufen.');

            return Redirect::route('users.index');
        }

        User::find($id)->fill(role: $role)->save();

        return Redirect::route('users.index');
    }
}
