<?php

namespace Delta\Components\Layer\Support\Controller\Abilities;

use ReflectionClass;
use ReflectionMethod;
use ReflectionAttribute;

use Delta\Components\Store\{Store, Enums\StoreType};
use Delta\Components\Routing\{RouteMeta, RouteAlias};
use Delta\Components\Routing\Attributes\{Route, Middleware};
use Delta\Components\Layer\Exceptions\ReflectionAttributeException;

trait CanResolveRouteAttribute
{
    private function setGlobalRouteName(string $key, string $route): void
    {
        if (!RouteAlias::exists($key)) {
            RouteAlias::setName($key, $route);
        }
    }

    private function getRouteName(ReflectionMethod $reflection): string
    {
        return $reflection->name;
    }

    private function getMiddlewares(
        ReflectionClass|ReflectionMethod $reflection,
    ): array {
        $attributes = $reflection->getAttributes(Middleware::class);

        if (empty($attributes)) {
            return [];
        }

        $attribute = current($attributes);

        if (!is_object($attribute)) {
            throw new ReflectionAttributeException();
        }

        $instance = $attribute->newInstance();

        return $instance->middlewares;
    }

    private function getRoutes(
        ReflectionClass $reflection,
        string $prefix,
    ): array {
        $routes = [];

        $classMiddlewares = $this->getMiddlewares($reflection);

        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $filteredMethods = array_filter(
            $methods,
            fn(ReflectionMethod $method) => $method->name !== "__construct",
        );

        foreach ($filteredMethods as $method) {
            $methodMiddlewares = $this->getMiddlewares($method);

            $attributes = $method->getAttributes(
                Route::class,
                ReflectionAttribute::IS_INSTANCEOF,
            );

            $attribute = current($attributes)->newInstance();

            $key =
                $this->getRoutePrefixName($reflection) . "." . $attribute->name;

            if (!empty($key)) {
                $route = $prefix . $attribute->path;

                $this->setGlobalRouteName($key, $route);
            }

            $store = $this->container->resolve(Store::class);

            $providers = $store->get(
                $this->getParentModule(),
                StoreType::PROVIDER,
            );
            $exports = $store->get($this->getParentModule(), StoreType::EXPORT);

            $injectors = [...$providers, ...$exports];

            $routes[$attribute->method][$attribute->path][
                "meta"
            ] = new RouteMeta(
                method: $method,
                reflection: $reflection,
                providers: $injectors,
            );

            $middlewares = array_merge($classMiddlewares, $methodMiddlewares);

            $routes[$attribute->method][$attribute->path][
                "middlewares"
            ] = $middlewares;
        }

        return $routes;
    }
}
