<?php

namespace App\Infrastructure\Http\Controller;

use App\Application\Auth\LoginCommand;
use App\Application\Auth\LoginHandler;
use App\Shared\JsonRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController
{
    #[Route('/api/auth/login', name: 'auth_login', methods: ['POST'])]
    public function login(Request $request, LoginHandler $handler): JsonResponse
    {
        try {
            $payload = JsonRequest::decode($request);
            $token = $handler->handle(new LoginCommand(
                login: (string) ($payload['login'] ?? ''),
                password: (string) ($payload['password'] ?? ''),
            ));

            return new JsonResponse(['token' => $token]);
        } catch (\DomainException|\InvalidArgumentException) {
            return new JsonResponse(['error' => 'Invalid credentials.'], 401);
        }
    }
}
