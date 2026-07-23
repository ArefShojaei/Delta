<?php

namespace Delta\Components\Cache\Interfaces;

interface Cache
{
    public static function set(string $key, mixed $value, int $ttl = 0): bool;

    public static function get(string $key, mixed $default = null): mixed;

    public static function has(string $key): bool;

    public static function delete(string $key): bool;

    public static function clear(): bool;
}
