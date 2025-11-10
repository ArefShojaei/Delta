<?php

namespace Delta\Application\Layers;

use Delta\Application\Layers\{
    Module\ModuleLayer,
    Controller\ControllerLayer,
    Provider\ProviderLayer
};
use Delta\Components\Layer\LayerFactory;


trait LayerRegisteration
{
    protected function registerLayers(): void
    {
        $this->registerModuleLayer();
    }

    private function registerModuleLayer(): void
    {
        $moduleLayer = LayerFactory::createModuleLayer($this->module, $this->bootstrap->getContainer());

        $moduleLayer->process();
    }

    private function registerControllerLayer(): void
    {
        // TODO: Implement Controller layer registration
    }

    private function registerProviderLayer(): void
    {
        // TODO: Implement Provider layer registration
    }
}
