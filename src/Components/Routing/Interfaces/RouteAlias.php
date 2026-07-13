<?php

namespace Delta\Components\Routing\Interfaces;

interface RouteAlias
{
    public static function setName(string $name, string $route): void;

    public static function getName(string $name): ?string;

    public static function exists(string $name): bool;
}
