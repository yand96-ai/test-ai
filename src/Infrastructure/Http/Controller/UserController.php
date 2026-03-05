<?php

namespace App\Infrastructure\Http\Controller;

use App\Application\User\RegisterUserCommand;
use App\Application\User\RegisterUserHandler;
use App\Shared\JsonRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserController
{
    #[Route('/api/users/register', name: 'users_register', methods: ['POST'])]
    public function register(Request $request, RegisterUserHandler $handler): JsonResponse
    {
        try {
            $payload = JsonRequest::decode($request);
            $login = trim((string) ($payload['login'] ?? ''));
            $password = (string) ($payload['password'] ?? '');

            if ($login === '' || $password === '') {
                return new JsonResponse(['error' => 'Login and password are required.'], 400);
            }

            $user = $handler->handle(new RegisterUserCommand($login, $password));

            return new JsonResponse([
                'id' => $user->id(),
                'login' => $user->login(),
            ], 201);
        } catch (\DomainException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 409);
        } catch (\InvalidArgumentException) {
            return new JsonResponse(['error' => 'Invalid JSON payload.'], 400);
        }
    }
}
