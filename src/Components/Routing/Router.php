<?php

namespace Delta\Components\Routing;

use Closure;
use Delta\Components\Routing\Interfaces\Router as IRouter;


final class Router implements IRouter
{
    private array $routes = [];

    
    public function addRoute(
        string $method,
        string $path,
        RouteMeta|Closure $meta,
    ): void {
        $this->routes[$method][$path] = new Route(
            method: $method,
            path: $path,
            meta: $meta,
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
        $validator = new RouterValidator($this->routes);

        if (!$validator->isMethodExists($method)) die(RouteContentCreator::createUnsupportedMethod($method));

        return !$validator->isPathExists($method, $path)
            ? RouteContentCreator::createFallback()
            : $this->getRouteFromRequest($method, $path);
    }

    public function execute(Route $route, array $http): mixed
    {
        if ($route->meta instanceof Closure) return call_user_func($route->meta, $http);

        $meta = $route->meta;

        return $meta->method->invokeArgs($meta->reflection->newInstance(), $http);
    }
}
