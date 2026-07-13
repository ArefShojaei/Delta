<?php

namespace Delta\Components\Routing;

use Delta\Components\Routing\Interfaces\RouteAlias as IRouteAlias;

final class RouteAlias implements IRouteAlias
{
    private static array $names = [];

    public static function setName(string $name, string $route): void
    {
        self::$names[$name] = $route;
    }

    public static function getName(string $name): ?string
    {
        return self::$names[$name] ?? null;
    }

    public static function exists(string $name): bool
    {
        return isset(self::$names[$name]);
    }
}
