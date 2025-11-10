<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\LayerFactory;


trait CanDispatchControllers
{
    protected function dispatch(array $controllers)
    {
        foreach ($controllers as $controller) {
            $controllerLayer = LayerFactory::createControllerLayer($controller, $this->container);

            $controllerLayer->process();
        }
    }
}
