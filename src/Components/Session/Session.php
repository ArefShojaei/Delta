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
        if (!isset($_SESSION[$key])) return false;

        unset($_SESSION[$key]);

        return true;
    }

    public static function clean(): void
    {
        session_destroy();
    }

    public static function all(): array
    {
        return $_SESSION;
    }
}
