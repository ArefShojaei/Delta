<?php

namespace Delta\Application\Layers\Controller\Abilities;

use ReflectionClass;
use ReflectionMethod;
use ReflectionAttribute;
use Delta\Store\LayerStore;
use Delta\Components\Routing\RouteMeta;
use Delta\Components\Layer\Enums\LayerType;
use Delta\Components\Routing\Attributes\{Route, Middleware};


trait CanResolveRouteAttribute
{
    private function setGlobalRouteName(string $key, string $route): void
    {
        global $_ROUTE_NAMES;

        if (!isset($_ROUTE_NAMES[$key])) {
            $_ROUTE_NAMES[$key] = $route;
        }
    }

    private function getRouteName(ReflectionMethod $reflection): string
    {
        return $reflection->name;
    }

    private function getMiddlewares(ReflectionClass|ReflectionMethod $reflection): array
    {
        $attributes = $reflection->getAttributes(Middleware::class);

        if (empty($attributes)) return [];

        $attribute = current($attributes)->newInstance();

        return $attribute->middlewares;
    }

    private function getRoutes(ReflectionClass $reflection): array
    {
        $routes = [];

        $classMiddlewares = $this->getMiddlewares($reflection);

        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $filteredMethods = array_filter($methods, fn(ReflectionMethod $method) => $method->name !== "__construct");

        foreach ($filteredMethods as $method) {
            $methodMiddlewares = $this->getMiddlewares($method);

            $attributes = $method->getAttributes(
                Route::class,
                ReflectionAttribute::IS_INSTANCEOF,
            );

            $attribute = current($attributes)->newInstance();


            $key = $this->getRoutePrefixName($reflection) . $attribute->name;

            if (!empty($key)) $this->setGlobalRouteName($key, $attribute->path);

            
            $providers = $this->container->resolve(LayerStore::class)->getDependencies(LayerType::PROVIDER->value) ?? [];

            $routes[$attribute->method][$attribute->path]["meta"] = new RouteMeta(
                method: $method,
                reflection: $reflection,
                providers: $providers
            );

            $middlewares = array_merge($classMiddlewares, $methodMiddlewares);

            $routes[$attribute->method][$attribute->path]["middlewares"] = $middlewares;
        }

        return $routes;
    }
}
