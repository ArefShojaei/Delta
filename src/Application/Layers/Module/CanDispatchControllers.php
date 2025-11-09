<?php

namespace Delta\Application\Layers\Module;

use Delta\Components\Routing\Attributes\{Controller, Middleware, Route};
use Delta\Components\Routing\{
    Router,
    RouteMeta
};
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;


trait CanDispatchControllers
{
    private function getPrefix(ReflectionClass $reflection): ?string
    {
        $attributes = $reflection->getAttributes(Controller::class);

        $attribute = current($attributes)->newInstance();

        return $attribute->prefix;
    }

    private function getMiddlewares(ReflectionClass|ReflectionMethod $reflection): array
    {
        $attributes = $reflection->getAttributes(Middleware::class);

        $attribute = current($attributes)->newInstance();

        return $attribute->middlewares;
    }

    private function getRoutes(ReflectionClass $reflection): array
    {
        $routes = [];

        $classMiddlewares = $this->getMiddlewares($reflection);

        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $methodMiddlewares = $this->getMiddlewares($method);

            $attributes = $method->getAttributes(
                Route::class,
                ReflectionAttribute::IS_INSTANCEOF,
            );

            $attribute = current($attributes)->newInstance();

            $routes[$attribute->method][$attribute->path]["meta"] = new RouteMeta(
                method: $method,
                reflection: $reflection
            );

            $middlewares = array_merge($classMiddlewares, $methodMiddlewares);

            $routes[$attribute->method][$attribute->path]["middlewares"] = $middlewares;
        }

        return $routes;
    }

    private function registerRoutes(string $prefix, array $routes): void
    {
        $router = $this->container->resolve(Router::class);

        foreach ($routes as $method => $meta) {
            foreach ($meta as $route => $data) {
                $router->addRoute(
                    method: $method,
                    path: $prefix . ltrim($route, "/"),
                    meta: $data["meta"],
                    middlewares: $data["middlewares"],
                );
            }
        }
    }

    private function dispatch(array $controllers)
    {
        foreach ($controllers as $controller) {
            $controllerReflection = new ReflectionClass($controller);

            $this->registerRoutes(
                prefix: $this->getPrefix($controllerReflection),
                routes: $this->getRoutes($controllerReflection)
            );
        }
    }
}
