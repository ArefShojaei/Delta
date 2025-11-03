<?php

namespace Delta\Components\Session;

use Delta\Components\Session\Interfaces\Session as ISession;


final class Session implements ISession
{
    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

    public static function remove(string $key): bool
    {
        unset($_SESSION[$key]);

        return isset($_SESSION[$key]);
    }

    public static function clean(): void
    {
        unset($_SESSION);
    }

    public static function all(): array
    {
        return $_SESSION;
    }
}
