<?php

namespace Delta\Components\Cookie;

use Delta\Components\Cookie\Interfaces\Cookie as ICookie;

final class Cookie implements ICookie
{
    private const DELETE_EXPIRES_OFFSET = 3600;

    public static function set(
        string $key,
        string $value,
        int $expires = 0,
        string $path = "",
        string $domain = "",
        bool $secure = false,
        bool $httponly = false,
    ): void {
        setcookie($key, $value, $expires, $path, $domain, $secure, $httponly);

        $_COOKIE[$key] = $value;
    }

    public static function get(string $key): ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    public static function remove(string $key): bool
    {
        setcookie($key, "", time() - self::DELETE_EXPIRES_OFFSET);

        unset($_COOKIE[$key]);

        return true;
    }

    public static function clean(): void
    {
        foreach (array_keys($_COOKIE) as $key) {
            self::remove($key);
        }
    }

    public static function all(): array
    {
        return $_COOKIE;
    }
}
