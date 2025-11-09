<?php

namespace Delta\Components\Routing\Interfaces;

use Delta\Components\Routing\{ Route, RouteMeta };


interface Router
{
    public function addRoute(
        string $method,
        string $path,
        RouteMeta $meta,
        array $middlewares = [],
    ): void;

    public function getRoutes(?string $method = null): array;

    public function findRoute(string $method, string $path): Route;

    public function dispatch(Route $route, array $http): void;
}
