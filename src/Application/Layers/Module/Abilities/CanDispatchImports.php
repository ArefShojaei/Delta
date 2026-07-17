<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\LayerFactory;

trait CanDispatchImports
{
    protected function dispatch(array $imports)
    {
        if (empty($imports)) return;

        foreach ($imports as $module) {
            $subModuleLayer = LayerFactory::createModuleLayer(
                $module,
                $this->container,
            );

            $subModuleLayer->process();
        }
    }
}
