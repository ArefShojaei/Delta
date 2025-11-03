<?php

namespace Delta\Application\Providers;

use Delta\Application\Interfaces\LayerProvider as ILayerProvider;
use Delta\Application\Layers\Module\{
    CanDispatchControllers,
    CanDispatchProviders,
    CanDispatchImports,
    CanDispatchExports,
    CanGetAttribute,
};


final class ModuleLayerProvider implements ILayerProvider
{
    use CanDispatchControllers,
        CanDispatchProviders,
        CanDispatchImports,
        CanDispatchExports {
        CanDispatchControllers::dispatch insteadof CanDispatchProviders, CanDispatchImports, CanDispatchExports;

        CanDispatchControllers::dispatch as private dispatchControllers;
        CanDispatchProviders::dispatch as private dispatchProviders;
        CanDispatchImports::dispatch as private dispatchImports;
        CanDispatchExports::dispatch as private dispatchExports;
    }

    use CanGetAttribute;

    public function __construct(private readonly string $module) {}

    public function process(): void
    {
        $this->dispatchControllers($this->getAttributeControllers());

        $this->dispatchProviders($this->getAttributeProviders());

        $this->dispatchImports($this->getAttributeImports());

        $this->dispatchExports($this->getAttributeExports());
    }
}
