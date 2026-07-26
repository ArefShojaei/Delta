<?php

namespace Delta\Components\Cache;

use Delta\Components\Config\Config;
use Delta\Components\Cache\Exceptions\CacheException;
use Delta\Components\Cache\Interfaces\Cache as ICache;

final class Cache implements ICache
{
    public static function set(string $key, mixed $value, int $ttl = 0): bool
    {
        $data = [
            "value" => $value,
            "expires" => $ttl > 0 ? time() + $ttl : 0,
        ];

        return @file_put_contents(self::file($key), serialize($data), LOCK_EX);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (!self::has($key)) return $default;

        return unserialize(file_get_contents(self::file($key)))["value"];
    }

    public static function has(string $key): bool
    {
        $file = self::file($key);

        if (!file_exists($file)) return false;

        $data = unserialize(file_get_contents($file));

        if ($data["expires"] !== 0 && $data["expires"] < time()) {
            unlink($file);

            return false;
        }

        return true;
    }

    public static function delete(string $key): bool
    {
        $file = self::file($key);

        if (file_exists($file)) unlink($file);

        return true;
    }

    public static function clear(): bool
    {
        $path = Config::get("storage.cache.path");

        if (!$path) throw new CacheException("Cache path is not defined!");

        foreach (glob($path . "/*.cache") as $file) {
            unlink($file);
        }

        return true;
    }

    private static function file(string $key): string
    {
        $path = Config::get("storage.cache.path");

        if (!$path) throw new CacheException("Cache path is not defined!");

        return $path . "/" . sha1($key) . ".cache";
    }
}
