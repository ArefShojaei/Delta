<?php

namespace Delta\Components\Config;

use Delta\Components\Config\Interfaces\Config as IConfig;

final class Config implements IConfig
{
    private static $data = [];

    public static function set(array $settings): void
    {
        self::$data = array_replace_recursive(self::$data, $settings);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $segments = explode(".", $key);

        $data = self::$data;

        foreach ($segments as $segment) {
            if (!self::has($segment)) return $default;

            $data = $data[$segment];
        }

        return $data;
    }

    public static function has(string $segment): bool
    {
        return isset(self::$data[$segment]);
    }

    public static function all(): array
    {
        return self::$data;
    }
}
