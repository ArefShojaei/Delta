<?php

namespace Delta\Components\Config\Interfaces;

interface Config {
    public static function set(array $settings): void;

    public static function get(string $key, mixed $default = null): mixed;

    public static function all(): array;
}
