<?php

namespace Delta\Components\Routing\Interfaces;

use Delta\Components\Routing\Route;


interface Router
{
    public function addRoute(
        string $method,
        string $path,
        object $callback,
    ): void;

    public function getRoutes(): array;

    public function findRoute(string $method, string $path): Route;

    public function execute(Route $route, array $http): mixed;
}
