<?php

namespace App\Controllers;

use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;
use PXP\Lib\Auth;
use App\Notification;

class LoginController extends Controller
{
    public function form(): Response
    {
        return view('login');
    }

    public function login(): Response
    {
        $request = request()->validate(fn ($req) => [
            $req->email->string(),
            $req->password->string(),
        ]);

        if (! Auth::login($request->email, $request->password)) {
            Notification::warn('Ungültige Zugangsdaten gegeben.');

            return Redirect::route('login');
        }

        if (! $user = Auth::user()) {
            return Redirect::route('login');
        }

        return Redirect::route('main');
    }

    public function logout(): Response
    {
        Auth::logout();

        return Redirect::route('main');
    }
}
