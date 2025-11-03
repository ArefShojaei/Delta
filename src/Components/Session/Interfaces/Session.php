<?php

namespace Delta\Components\Session\Interfaces;


interface Session
{
    public static function set(string $key, string $value): void;

    public static function get(string $key): ?string;

    public static function remove(string $key): bool;

    public static function clean(): void;

    public static function all(): array;
}
