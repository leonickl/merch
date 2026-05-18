<?php

namespace App\Middleware;

use App\Enums\Role;
use PXP\Exceptions\UnauthorizedException;
use PXP\Http\Middleware\Middleware;
use PXP\Http\Response\View;
use PXP\Lib\Auth;

class RequireAdmin extends Middleware
{
    public function apply(): true|View
    {
        if (! Auth::user()?->role >= Role::ADMIN->value) {
            throw new UnauthorizedException('Zugriff nur als Admin');
        }

        return true;
    }
}
