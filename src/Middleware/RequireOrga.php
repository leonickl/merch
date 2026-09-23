<?php

namespace App\Middleware;

use PXP\Auth\Auth;
use PXP\Auth\Role;
use PXP\Exceptions\UnauthorizedException;
use PXP\Http\Middleware\Middleware;
use PXP\Http\Response\View;

class RequireOrga extends Middleware
{
    public function apply(): true|View
    {
        if (! Auth::user()?->role()->atLeast(Role::ORGA())) {
            throw new UnauthorizedException('Zugriff nur als Organisator:in');
        }

        return true;
    }
}
