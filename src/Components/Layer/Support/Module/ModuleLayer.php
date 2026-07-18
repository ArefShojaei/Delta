<?php

namespace Delta\Components\Layer\Support\Module;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use Delta\Components\Layer\Support\Module\Abilities\{
    CanDispatchControllers,
    CanDispatchExports,
    CanDispatchProviders,
    CanDispatchImports,
    CanGetAttribute,
};

final class ModuleLayer implements ILayerProvider
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

    public function __construct(
        private readonly string|object $module,
        private Container $container,
    ) {}

    public function process(): void
    {
        $this->getAttributeImports() &&
            $this->dispatchImports($this->getAttributeImports());

        $this->getAttributeProviders() &&
            $this->dispatchProviders($this->getAttributeProviders());

        $this->getAttributeExports() &&
            $this->dispatchExports($this->getAttributeExports());

        $this->getAttributeControllers() &&
            $this->dispatchControllers($this->getAttributeControllers());
    }
}
