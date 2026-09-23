<?php

use PXP\Data\DB;

require __DIR__.'/vendor/autoload.php';

$db = DB::init();

$db->create('users', [
    'email' => 'text not null unique',
    'password_hash' => 'text not null',
    'role' => 'int not null default 0',
    'first_name' => 'string not null',
    'last_name' => 'string not null',
    'verified' => 'int not null default 0',
]);

$db->sql('create unique index if not exists '.
    'unique_users_email on users(email)');

$db->create('verification_link', [
    'token' => 'string not null',
    'user_id' => 'int references user(id)',
]);

$db->create('merchs', [
    'title' => 'text not null',
    'sizes' => 'int not null',
    'status' => 'int not null',
]);

$db->create('orders', [
    'title' => 'string not null',
    'status' => 'int not null',
]);

$db->create('items', [
    'order_id' => 'int references orders(id)',
    'user_id' => 'int references users(id)',
    'merch_id' => 'int references merchs(id)',
    'size' => 'int not null',
]);
