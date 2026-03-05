<?php

namespace App\Infrastructure\Persistence;

final class PdoFactory
{
    public static function create(): \PDO
    {
        $databaseUrl = $_ENV['DATABASE_URL'] ?? $_SERVER['DATABASE_URL'] ?? '';

        if ($databaseUrl === '') {
            throw new \RuntimeException('DATABASE_URL is not configured.');
        }

        $parts = parse_url($databaseUrl);
        if (!is_array($parts)) {
            throw new \RuntimeException('Invalid DATABASE_URL format.');
        }

        $host = $parts['host'] ?? 'localhost';
        $port = $parts['port'] ?? 5432;
        $db = ltrim($parts['path'] ?? '/app', '/');
        $user = $parts['user'] ?? 'app';
        $pass = $parts['pass'] ?? 'app';

        $dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s', $host, $port, $db);

        return new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }
}
