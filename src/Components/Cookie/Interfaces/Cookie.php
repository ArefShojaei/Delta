<?php

namespace Delta\Components\Cookie\Interfaces;

interface Cookie
{
    public static function set(
        string $key,
        string $value,
        int $expires = 0,
        string $path = "",
        string $domain = "",
        bool $secure = false,
        bool $httponly = false,
    ): void;

    public static function get(string $key): ?string;

    public static function remove(string $key): bool;

    public static function clean(): void;

    public static function all(): array;
}
