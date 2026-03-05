<?php

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserPasswordHasherInterface $hasher,
    ) {
    }

    public function handle(RegisterUserCommand $command): User
    {
        if (null !== $this->repository->findByLogin($command->login)) {
            throw new \DomainException('Login already exists.');
        }

        $hashed = $this->hasher->hashPassword(new SymfonyPasswordUser($command->login), $command->password);

        return $this->repository->save(new User(
            id: null,
            login: $command->login,
            passwordHash: $hashed,
        ));
    }
}
