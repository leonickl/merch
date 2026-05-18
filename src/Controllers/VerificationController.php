<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\VerificationLink;
use App\Notification;
use PXP\Exceptions\DisplayException;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;

class VerificationController extends Controller
{
    public function verify(): Response
    {
        $token = request()->string('token');

        $link = VerificationLink::findByOrNull('token', $token) ??
            error(DisplayException::class, 'Ungültiger Token');

        $link->isValid() ?:
            error(DisplayException::class, 'Token abgelaufen');

        User::find($link->user_id)->fill(verified: true)->save();

        Notification::success('E-Mail-Adresse erfolgreich verifiziert. Du kannst dich jetzt einloggen.');

        return Redirect::route('login');
    }
}
