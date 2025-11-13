<?php

namespace Delta\Application\Layers\Controller\Abilities;

use Delta\Components\Layer\Attributes\Controller;
use Delta\Components\Layer\Enums\LayerType;
use Delta\Components\Routing\Attributes\{Middleware, Route};
use Delta\Components\Routing\{RouteMeta, Router};
use Delta\Store\LayerStore;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;


trait CanRegisterRoute
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

    private function registerRoutes(string $prefix, array $routes): void
    {
        $router = $this->container->resolve(Router::class);

        foreach ($routes as $method => $meta) {
            foreach ($meta as $route => $data) {
                $router->addRoute(
                    method: $method,
                    path: $prefix . $route,
                    meta: $data["meta"],
                    middlewares: $data["middlewares"],
                );
            }
        }
    }
}
