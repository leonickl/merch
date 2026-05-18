<?php

use App\Models\User;
use PXP\Console\Command;

Command::new('create:user', function (?string $first_name, ?string $last_name, ?string $email, ?string $password, string $role = '0') {
    if ($first_name === null) {
        exit("Please enter a first name\n");
    }

    if ($last_name === null) {
        exit("Please enter a last name\n");
    }

    if ($email === null) {
        exit("Please enter an email address\n");
    }

    if ($password === null) {
        exit("Please enter a password\n");
    }

    $user = User::create(
        first_name: $first_name,
        last_name: $last_name,
        username: $email,
        password_hash: password_hash($password, PASSWORD_DEFAULT),
        role: (int) $role,
    );

    echo "created user with id $user->id\n";
});
