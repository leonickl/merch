<?php

namespace App\Controllers;

use PXP\Auth\Auth;
use PXP\Auth\Models\User;
use PXP\Auth\Role;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;
use PXP\Lib\Notification;

class UserController extends Controller
{
    public function index(): Response
    {
        return view('users.index', [
            'users' => User::all(),
        ]);
    }

    public function setRole(int $id): Response
    {
        $role = request()->int('role');

        if (! Role::valid($role)) {
            Notification::warn('Keine valide Rolle gegeben.');

            return Redirect::route('users.index');
        }

        if (Auth::user()?->id === $id) {
            Notification::warn('Du kannst dich nicht selbst umstufen.');

            return Redirect::route('users.index');
        }

        if ($role > Auth::user()?->role) {
            Notification::warn('Du kannst keine höheren Rollen als deine eigene vergeben.');

            return Redirect::route('users.index');
        }

        User::find($id)->fill(role: $role)->save();

        return Redirect::route('users.index');
    }
}
