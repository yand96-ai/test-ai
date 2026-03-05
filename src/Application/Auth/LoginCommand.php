<?php

namespace App\Application\Auth;

final class LoginCommand
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
    ) {
    }
}
