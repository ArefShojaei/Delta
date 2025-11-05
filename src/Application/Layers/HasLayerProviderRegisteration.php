<?php

namespace Delta\Application\Layers;

use Delta\Application\Providers\ModuleLayerProvider;


trait HasLayerProviderRegisteration
{
    private function registerLayerProviders(): void
    {
        $this->registerModuleLayerProvider();

        $this->registerControllerLayerProvider();

        $this->registerServiceLayerProvider();
    }

    private function registerModuleLayerProvider(): void
    {
        $moduleLayer = new ModuleLayerProvider($this->module);

        $moduleLayer->process();

        exit();
    }

    private function registerControllerLayerProvider(): void {}

    private function registerServiceLayerProvider(): void {}
}
