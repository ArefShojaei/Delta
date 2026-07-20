<?php

namespace Delta\Components\Layer\Support\Module\Abilities;

use Delta\Components\Layer\Factory\LayerFactory;

trait CanDispatchExports
{
    protected function dispatch(array $exports)
    {
        if (empty($exports)) return;

        foreach ($exports as $provider) {
            $layer = LayerFactory::createExportLayer(
                $provider,
                $this->container,
            );

            $layer->setParentModule($this->module);

            $layer->process();
        }
    }
}
