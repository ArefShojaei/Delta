<?php

namespace Delta\Components\Routing;

use Delta\Components\Routing\Contracts\RouterContract;


final class Router implements RouterContract
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

    private function getRouteFromRequest(string $method, string $path): Route
    {
        return $this->routes[$method][$path];
    }

    public function findRoute(string $method, string $path): Route
    {
        $validator = new RouteValidator($this->routes);

        if (!$validator->isMethodExists($method)) RouteContentCreator::createUnsupportedMethod($method);

        return !$validator->isPathExists($method, $path) ? RouteContentCreator::createFallback() : $this->getRouteFromRequest($method, $path);
    }

    public function execute(Route $route, array $http): mixed
    {
        return call_user_func($route->callback, $http);
    }
}
