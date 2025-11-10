<?php

namespace Delta\Application\Layers\Controller;

use Delta\Application\Layers\Controller\Abilities\CanRegisterRoute;
use Delta\Components\Container\Container;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use ReflectionClass;


final class ControllerLayer implements ILayerProvider
{
    use CanRegisterRoute;

    public function __construct(private readonly string $controller, private Container $container) {}

    public function process(): void {
        $controllerReflection = new ReflectionClass($this->controller);

        $this->registerRoutes(
            prefix: $this->getPrefix($controllerReflection),
            routes: $this->getRoutes($controllerReflection)
        );
    }
}
