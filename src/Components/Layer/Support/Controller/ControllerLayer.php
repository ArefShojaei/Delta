<?php

namespace Delta\Components\Layer\Support\Controller;

use ReflectionClass;

use Delta\Components\Container\Container;
use Delta\Components\Layer\BaseSupportLayer;
use Delta\Components\Layer\Exceptions\ReflectionModuleException;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use Delta\Components\Layer\Support\Controller\Abilities\{
    CanRegisterRoute,
    CanResolveControllerAttribute,
    CanResolveRouteAttribute,
};

final class ControllerLayer extends BaseSupportLayer implements ILayerProvider
{
    use CanRegisterRoute,
        CanResolveControllerAttribute,
        CanResolveRouteAttribute;

    public function __construct(
        private readonly string|object $controller,
        private Container $container,
    ) {}

    public function process(): void
    {
        $controllerReflection = new ReflectionClass($this->controller);

        if (!$controllerReflection) {
            throw new ReflectionModuleException();
        }

        $parentPrefixRoute = $this->getPrefix($controllerReflection);

        $this->registerRoutes(
            prefix: $parentPrefixRoute,
            routes: $this->getRoutes($controllerReflection, $parentPrefixRoute),
        );
    }
}
