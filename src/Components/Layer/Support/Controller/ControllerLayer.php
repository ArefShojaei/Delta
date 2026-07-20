<?php

namespace Delta\Components\Layer\Support\Controller;

use ReflectionClass;

use Delta\Components\Container\Container;
use Delta\Components\Layer\BaseSupportLayer;
use Delta\Common\Interfaces\Processor as IProcessor;
use Delta\Components\Layer\Exceptions\ReflectionModuleException;
use Delta\Components\Layer\Support\Controller\Abilities\{
    CanRegisterRoute,
    CanResolveControllerAttribute,
    CanResolveRouteAttribute,
};

final class ControllerLayer extends BaseSupportLayer implements IProcessor
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

        $this->registerRoutes(
            prefix: $this->getPrefix($controllerReflection),
            routes: $this->getRoutes($controllerReflection),
        );
    }
}
