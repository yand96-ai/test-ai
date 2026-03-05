<?php

namespace App\Application\Auth;

use App\Application\User\SymfonyPasswordUser;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Security\JwtTokenGenerator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class LoginHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly JwtTokenGenerator $tokenGenerator,
    ) {
    }

    public function handle(LoginCommand $command): string
    {
        $user = $this->repository->findByLogin($command->login);

        if (!$user) {
            throw new \DomainException('Invalid credentials.');
        }

        $passwordUser = new SymfonyPasswordUser($user->login(), $user->passwordHash());

        if (!$this->hasher->isPasswordValid($passwordUser, $command->password)) {
            throw new \DomainException('Invalid credentials.');
        }

        return $this->tokenGenerator->generate($user->id() ?? 0, $user->login());
    }
}
