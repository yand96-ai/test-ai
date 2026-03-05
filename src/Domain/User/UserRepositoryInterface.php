<?php

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function findByLogin(string $login): ?User;

    public function save(User $user): User;
}
