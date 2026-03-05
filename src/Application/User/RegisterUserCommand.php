<?php

namespace App\Application\User;

final class RegisterUserCommand
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
    ) {
    }
}
