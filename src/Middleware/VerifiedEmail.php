<?php

namespace App\Middleware;

use PXP\Exceptions\UnauthorizedException;
use PXP\Http\Middleware\Middleware;
use PXP\Http\Response\View;
use PXP\Lib\Auth;

class VerifiedEmail extends Middleware
{
    public function apply(): true|View
    {
        if (! Auth::user()?->verified) {
            throw new UnauthorizedException('Zugriff nur mit verifizierter E-Mail-Adresse');
        }

        return true;
    }
}
