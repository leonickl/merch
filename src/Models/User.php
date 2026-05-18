<?php

namespace App\Models;

use App\Enums\Role;
use App\Mail;
use PXP\Data\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password_hash
 * @property int $role
 * @property bool $verified
 */
class User extends Model
{
    protected string $table = 'users';

    public function setPasswordHash(string $password): void
    {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function role(): Role
    {
        return Role::make($this->role);
    }

    public function is(Role $role): bool
    {
        return $this->role() === $role;
    }

    public function sendVerification(): void
    {
        $link = VerificationLink::create(user_id: $this->id)->url();

        new Mail(
            subject: 'E-Mail-Adresse verifizieren',
            body: "Klicke bitte auf den folgenden Link, um deine E-Mail-Adresse zu verifizieren: <a href=\"$link\">$link</a>. Er ist 15 Minuten gültig.",
            html: true,
        )
            ->send($this->username, $this->name);
    }

    public function fullName(): string
    {
        return "$this->first_name $this->last_name";
    }
}
