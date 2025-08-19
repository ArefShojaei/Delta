<?php

namespace Delta\Components\Routing;


interface RouterContract {
    public function addRoute(string $method, string $path, object $callback): void;
    public function getRoutes(): array;
    public function findRoute(string $method, string $path): Route;
    public function execute(Route $route, array $http): mixed;
}