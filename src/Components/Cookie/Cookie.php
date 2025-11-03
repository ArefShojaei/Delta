<?php

namespace Delta\Components\Cookie;

use Delta\Components\Cookie\Interfaces\Cookie as ICookie;


final class Cookie implements ICookie
{
    public static function set(string $key, string $value): void
    {
        $_COOKIE[$key] = $value;
    }

    public static function get(string $key): ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    public static function remove(string $key): bool
    {
        unset($_COOKIE[$key]);

        return isset($_COOKIE[$key]);
    }

    public static function clean(): void
    {
        unset($_COOKIE);
    }

    public static function all(): array
    {
        return $_COOKIE;
    }
}
