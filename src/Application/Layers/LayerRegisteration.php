<?php

namespace Delta\Application\Layers;

use Delta\Components\Layer\LayerFactory;

trait LayerRegisteration
{
    private function registerModuleLayer(): void
    {
        $layer = LayerFactory::createModuleLayer(
            $this->module,
            $this->bootstrap->getContainer(),
        );

        $layer->process();
    }
}
