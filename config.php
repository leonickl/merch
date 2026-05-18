<?php

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

    'mail' => (object) [
        'host' => env('MAIL_HOST'),
        'user' => env('MAIL_USER'),
        'pass' => env('MAIL_PASS'),
        'port' => env('MAIL_PORT'),
    ],
];
