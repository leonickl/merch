<?php

namespace App;

use App\Enums\Role;
use PXP\Ds\Obj;
use PXP\Lib\Auth;

class Nav
{
    /**
     * @return list<Obj>
     */
    protected function items(): array
    {
        $user = Auth::user();

        return [
            o(at: ['*'], not: ['/'], to: route('main'), how: 'Home', classes: 'secondary'),

            o(at: ['*'], to: route('merchs.index'), how: 'Merch', guard: fn () => $user->role >= Role::ORGA->value),
            o(at: ['*'], to: route('orders.index'), how: 'Bestellungen', guard: fn () => $user->role >= Role::ORGA->value),
            // o(at: ['*'], to: route('users.index'), how: 'Benutzer', guard: fn () => $user->role >= Role::ADMIN->value),

            o(at: ['/merchs'], to: route('merchs.create'), how: 'Neu', guard: fn () => $user->role >= Role::ORGA->value),
            o(at: ['/orders'], to: route('orders.create'), how: 'Neu', guard: fn () => $user->role >= Role::ORGA->value),
            o(at: ['/users'], to: route('orders.create'), how: 'Neu', guard: fn () => $user->role >= Role::ADMIN->value),

            o(at: ['/login'], to: route('register'), how: 'Registrieren'),
            o(at: ['/'], to: route('login'), how: 'Login', guard: fn () => $user === null, classes: 'secondary'),
            o(at: ['*'], to: route('logout'), how: 'Logout', classes: 'warn', guard: fn () => $user),
        ];
    }

    public function __toString()
    {
        $links = '';

        foreach ($this->items() as $item) {
            $allow_url = (in_array('*', $item->at) || in_array(url(), $item->at)) && ! in_array(url(), @$item->not ?? []);

            if ($allow_url && (@$item->guard ?? fn () => true)()) {
                $classes = @$item->classes ?? '';
                $style = @$item->style ?? '';

                $links .= "<a class=\"btn $classes\" href=\"$item->to\" style=\"$style\">$item->how</a>";
            }
        }

        return $links;
    }
}
