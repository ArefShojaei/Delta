<?php

namespace Delta\Components\Layer\Support\Module\Abilities;

use Delta\Components\Layer\Factory\LayerFactory;

trait CanDispatchControllers
{
    protected function dispatch(array $controllers)
    {
        if (empty($controllers)) return;

        foreach ($controllers as $controller) {
            $layer = LayerFactory::createControllerLayer(
                $controller,
                $this->container,
            );

            $layer->process();
        }
    }
}
