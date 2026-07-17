<?php

namespace Delta\Components\Layer;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Factory\LayerFactory;

abstract class LayerRegistry
{
    public function __construct(private Container $container) {}

    protected function register(string|object $module): void
    {
        $layer = LayerFactory::createModuleLayer($module, $this->container);

        $layer->process();
    }
}
