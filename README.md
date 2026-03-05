# Symfony API (Hexagonal/Clean Architecture)

API на последней стабильной ветке Symfony 7.3 с Docker Compose и PostgreSQL 17.

## Запуск

```bash
docker compose up --build
```

API будет доступно на `http://localhost:8000`.

## Ручки

### Healthcheck (без авторизации)

```http
GET /api/healthcheck
```

Пример ответа:

```json
{"status":"ok"}
```

### Регистрация пользователя

```http
POST /api/users/register
Content-Type: application/json

{
  "login": "alice",
  "password": "strong_password"
}
```

- Логин должен быть уникальным (ограничение в БД + проверка в приложении).
- Пароль сохраняется только как невосстановимый хэш (`password_hash`).

### Авторизация

```http
POST /api/auth/login
Content-Type: application/json

{
  "login": "alice",
  "password": "strong_password"
}
```

Ответ:

```json
{"token":"<jwt>"}
```

## Архитектура

- `src/Domain` — сущности и контракты.
- `src/Application` — use-cases (`RegisterUserHandler`, `LoginHandler`).
- `src/Infrastructure` — HTTP-контроллеры, PostgreSQL-репозиторий, JWT-генератор.

Это соответствует Clean/Hexagonal подходу: домен и application изолированы от инфраструктуры через интерфейсы.
