<?php

namespace App\Controllers;

use App\Models\User;
use App\Notification;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;

class RegisterController extends Controller
{
    public function form(): Response
    {
        return view('register');
    }

    public function register(): Response
    {
        $request = request()->validate(fn ($req) => [
            $req->email->string()->email()->min(6)->max(50),
            $req->first_name->string()->min(3)->max(40),
            $req->last_name->string()->min(3)->max(40),
            $req->password->string()->min(8)->max(100),
        ]);

        if (User::findAllBy('username', $request->email)->count() > 0) {
            Notification::warn('Diese E-Mail-Adresse ist schon registriert.');

            return Redirect::route('register');
        }

        User::create(
            first_name: $request->first_name,
            last_name: $request->last_name,
            username: $request->email,
            password_hash: password_hash($request->password, PASSWORD_DEFAULT),
        )
            ->sendVerification();

        Notification::info("Benutzer '$request->first_name $request->last_name'
            ($request->email) wurde erstellt. Bitte E-Mail-Adresse verifizieren.");

        return Redirect::route('login');
    }
}
