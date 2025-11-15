<?php

namespace Delta\Application\Layers\Module;

use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use Delta\Application\Layers\Module\Abilities\{
    CanDispatchControllers,
    CanDispatchProviders,
    CanDispatchImports,
    CanGetAttribute
};
use Delta\Components\Container\Container;


final class ModuleLayer implements ILayerProvider
{
    use CanDispatchControllers,
        CanDispatchProviders,
        CanDispatchImports {
        CanDispatchControllers::dispatch insteadof CanDispatchProviders, CanDispatchImports;

        CanDispatchControllers::dispatch as private dispatchControllers;
        CanDispatchProviders::dispatch as private dispatchProviders;
        CanDispatchImports::dispatch as private dispatchImports;
    }

    use CanGetAttribute;

    public function __construct(private readonly string|object $module, private Container $container) {}

    public function process(): void
    {
        $this->getAttributeProviders() && $this->dispatchProviders($this->getAttributeProviders());

        $this->getAttributeControllers() && $this->dispatchControllers($this->getAttributeControllers());

        $this->getAttributeImports() && $this->dispatchImports($this->getAttributeImports());
    }
}
