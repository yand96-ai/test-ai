<?php

namespace App\Shared;

use Symfony\Component\HttpFoundation\Request;

final class JsonRequest
{
    public static function decode(Request $request): array
    {
        $content = $request->getContent();
        if ($content === '') {
            return [];
        }

        $decoded = json_decode($content, true);
        if (!is_array($decoded)) {
            throw new \InvalidArgumentException('Invalid JSON payload.');
        }

        return $decoded;
    }
}
