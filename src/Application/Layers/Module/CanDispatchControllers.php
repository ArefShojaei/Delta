<?php

namespace Delta\Application\Layers\Module;

use Delta\Components\Routing\Attributes\{
    Controller,
    Route
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
            $attributes = $method->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF);
        
            $attribute = current($attributes)->newInstance();

            $routes[] = $attribute->path;
        }

        return $routes;
    }

    private function dispatch(array $controllers) {
        foreach ($controllers as $controller) {
            $controllerReflection = new ReflectionClass($controller);
            
            $this->getPrefix($controllerReflection);
            
            $this->getRoutes($controllerReflection);
        }
    }
}