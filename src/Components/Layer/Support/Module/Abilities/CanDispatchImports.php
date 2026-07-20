<?php

namespace Delta\Components\Layer\Support\Module\Abilities;

use Delta\Components\Layer\Factory\LayerFactory;

trait CanDispatchImports
{
    protected function dispatch(array $imports)
    {
        if (empty($imports)) return;

        foreach ($imports as $module) {
            $layer = LayerFactory::createImportLayer(
                $module,
                $this->container,
            );

            $layer->setParentModule($this->module);

            $layer->process();
        }
    }
}
