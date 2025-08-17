<?php

namespace Delta\Components\Routing;


final class Router
{
    private array $routes = [];


    public function addRoute(string $method, string $path, object $callback): void
    {
        $this->routes[$method][$path] = new Route(
            method: $method,
            path: $path,
            callback: $callback
        );
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function findRoute(string $method, string $path): ?Route
    {
        return $this->routes[$method][$path] ?? null;
    }

    public function execute(Route $route, array $http): mixed
    {
        return call_user_func($route->callback, $http);
    }
}
