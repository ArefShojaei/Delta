<?php

namespace Delta\Application\Layers\Controller;

use ReflectionClass;

use Delta\Components\Container\Container;
use Delta\Application\Layers\Provider\Abilities\CanResolveProvider;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use Delta\Application\Layers\Controller\Abilities\{
    CanRegisterRoute,
    CanResolveControllerAttribute,
    CanResolveRouteAttribute,
};

final class ControllerLayer implements ILayerProvider
{
    use CanRegisterRoute,
        CanResolveControllerAttribute,
        CanResolveRouteAttribute,
        CanResolveProvider;

    public function __construct(
        private readonly string|object $controller,
        private Container $container,
    ) {}

    public function process(): void
    {
        $controllerReflection = new ReflectionClass($this->controller);

        $this->registerRoutes(
            prefix: $this->getPrefix($controllerReflection),
            routes: $this->getRoutes($controllerReflection),
        );
    }
}
