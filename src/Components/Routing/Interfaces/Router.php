<?php

namespace Delta\Components\Routing\Interfaces;

use Closure;
use Delta\Components\Routing\Route;
use Delta\Components\Routing\RouteMeta;


interface Router
{
    public function addRoute(
        string $method,
        string $path,
        RouteMeta|Closure $meta,
    ): void;

    public function getRoutes(): array;

    public function findRoute(string $method, string $path): Route;

    public function execute(Route $route, array $http): mixed;
}
