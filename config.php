<?php

use PXP\Auth\Models\Identity;
use PXP\Auth\Models\User;

return [
    'title' => 'Merch',

    'app-url' => env('APP_URL', 'http://localhost:8100'),
    'port' => 8100,

    'css' => [
        'media',
        'colors',
        'base',
        'snippets',
        'button',
        'table',
        'notification',
        'components',
        'form',
    ],

    'js' => [
        'passkey',
    ],

    'mail' => (object) [
        'host' => env('MAIL_HOST'),
        'user' => env('MAIL_USER'),
        'pass' => env('MAIL_PASS'),
        'port' => env('MAIL_PORT'),
    ],

    'modules' => [
        'auth' => 'leonickl/pxp-auth',
    ],

    'resolver' => [
        Identity::class => User::class,
    ],

    'auth' => [
        'name-columns' => [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ],

        'roles' => [
            'levels' => [
                'REGULAR' => 0,
                'ORGA' => 1,
                'ADMIN' => 2,
            ],

            'labels' => [
                'REGULAR' => 'Benutzer:in',
                'ORGA' => 'Organisator:in',
                'ADMIN' => 'Admin',
            ],
        ],

        'relying-party' => [
            'name' => 'Merch',
            'id' => 'localhost',
        ],
    ],
];
