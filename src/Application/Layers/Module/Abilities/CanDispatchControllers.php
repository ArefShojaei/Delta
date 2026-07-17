<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\LayerFactory;

trait CanDispatchControllers
{
    protected function dispatch(array $controllers)
    {
        if (empty($controllers)) return;

        foreach ($controllers as $controller) {
            $controllerLayer = LayerFactory::createControllerLayer(
                $controller,
                $this->container,
            );

            $controllerLayer->process();
        }
    }
}
