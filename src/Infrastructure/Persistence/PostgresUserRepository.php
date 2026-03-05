<?php

namespace App\Infrastructure\Persistence;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;

final class PostgresUserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly \PDO $pdo)
    {
    }

    public function findByLogin(string $login): ?User
    {
        $stmt = $this->pdo->prepare('SELECT id, login, password_hash FROM users WHERE login = :login LIMIT 1');
        $stmt->execute(['login' => $login]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new User((int) $row['id'], $row['login'], $row['password_hash']);
    }

    public function save(User $user): User
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (login, password_hash) VALUES (:login, :password_hash) RETURNING id');
        $stmt->execute([
            'login' => $user->login(),
            'password_hash' => $user->passwordHash(),
        ]);

        $id = (int) $stmt->fetchColumn();

        return new User($id, $user->login(), $user->passwordHash());
    }
}
