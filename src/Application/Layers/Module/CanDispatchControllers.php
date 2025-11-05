<?php

namespace Delta\Application\Layers\Module;

use Delta\Components\Routing\Attributes\{Controller, Route};
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

    private function getRoutes(ReflectionClass $reflection): array
    {
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $routes = [];

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(
                Route::class,
                ReflectionAttribute::IS_INSTANCEOF,
            );

            $attribute = current($attributes)->newInstance();

            $routes[$attribute->method][$attribute->path] = new RouteMeta(
                method: $method,
                reflection: $reflection
            );
        }

        return $routes;
    }

    private function registerRoutes(string $prefix, array $routes): void
    {
        $router = $this->container->resolve(Router::class);

        foreach ($routes as $method => $meta) {
            foreach ($meta as $route => $callback) {
                $router->addRoute($method, $prefix . $route, $callback);
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
