<?php

namespace Delta\Components\Routing;

use Closure;
use Delta\Components\Http\Request;
use Delta\Components\Routing\Interfaces\Router as IRouter;
use Delta\Components\Routing\Attributes\{ MethodNotAllowed, NotFound };


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

    public function getRoutes(?string $method = null): array
    {
        return is_null($method) ? $this->routes : $this->routes[$method];
    }

    public function findRoute(string $method, string $uri): Route
    {
        $routes = $this->getRoutes();


        $validator = new RouterValidator($this->routes);

        if (!$validator->isMethodExists($method)) return $this->getRouteFromRequest(Request::READABLE, MethodNotAllowed::PATH);


        foreach ($routes[$method] as $pattern => $route) {
            [$isMatched, $matches] = $this->matchRoute($pattern, $uri);

            if ($isMatched) break;
        }

        if (!$isMatched) return $this->getRouteFromRequest(Request::READABLE, NotFound::PATH);


        $params = $this->getRouteParmas($matches);

        if ($params) $this->setRouteParams($params);


        return $route;
    }

    /**
     * @param array $htttp [$request, $response]
     */
    public function dispatch(Route $route, array $http): void
    {
        $currentClassReflection = $route->meta->reflection;

        $currentClassMethodReflection = $route->meta->method;


        $currentClassMethodReflection->invokeArgs($currentClassReflection->newInstance(), $http);
    }

    private function getRouteFromRequest(string $method, string $path): Route
    {
        return $this->routes[$method][$path];
    }

    /**
     * @param string $pattern The defined route pattern (e.g., "/products/{id}")
     * @param string $uri  The incoming request path (e.g., "/products/371")
     * @return array        [bool $isMatched, array $matches]
     */
    private function matchRoute(string $pattern, string $uri): array
    {
        $pattern = "/^" . str_replace(["/", "{", "}"], ["\/", "(?<", ">\w+)"], $pattern) . "$/";

        $isMatched = preg_match($pattern, $uri, $matches);

        return [$isMatched, $matches];
    }

    private function getRouteParmas(array $routeMatches): array
    {
        return array_filter($routeMatches, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);
    }

    private function setRouteParams(array $params): void
    {
        global $_PARAMS;

        $_PARAMS = $params;
    }
}
