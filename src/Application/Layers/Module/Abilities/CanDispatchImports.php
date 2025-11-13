<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\LayerFactory;


trait CanDispatchImports
{
    protected function dispatch(array $imports) {
        foreach ($imports as $module) {
            $subModuleLayer = LayerFactory::createModuleLayer($module, $this->container);

            $subModuleLayer->process();
        }
    }
}
