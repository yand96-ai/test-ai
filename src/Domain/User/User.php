<?php

namespace App\Domain\User;

final class User
{
    public function __construct(
        private readonly ?int $id,
        private readonly string $login,
        private readonly string $passwordHash,
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function login(): string
    {
        return $this->login;
    }

    public function passwordHash(): string
    {
        return $this->passwordHash;
    }
}
