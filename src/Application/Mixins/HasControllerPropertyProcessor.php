<?php

namespace Delta\Application\Mixins;

use Delta\Components\Reflection\Providers\{
    ClassReflectionProvider,
    MethodReflectionProvider
};
use Delta\Components\Routing\Attributes\{
    Controller,
    Route
};


trait HasControllerPropertyProcessor
{
    private function applyControllerMethods(array $methods, array $meta): void
    {
        foreach ($methods as $method) {
            $methodReflectionProvider = new MethodReflectionProvider($method, Route::class);

            $httpVerb = $methodReflectionProvider->descriptor->method;

            $path = $meta["prefix"] . $methodReflectionProvider->descriptor->path;

            $callback = $methodReflectionProvider->callback;

            $this->router->addRoute($httpVerb, $path, $callback);
        }
    }


    private function applyControllers(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $controllerReflectionProvider = new ClassReflectionProvider($controller, Controller::class);

            $prefix = "/" . ltrim($controllerReflectionProvider->descriptor->prefix, "/");

            $this->applyControllerMethods(
                methods: $controllerReflectionProvider->methods,
                meta: ["prefix" => $prefix]
            );
        }
    }
}
