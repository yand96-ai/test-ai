<?php

namespace App\Application\User;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class SymfonyPasswordUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(private readonly string $login, private readonly string $passwordHash = '')
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getPassword(): string
    {
        return $this->passwordHash;
    }
}
