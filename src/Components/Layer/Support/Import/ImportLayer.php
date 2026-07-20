<?php

namespace Delta\Components\Layer\Support\Import;

use Delta\Components\Container\Container;
use Delta\Components\Layer\BaseSupportLayer;
use Delta\Components\Layer\Factory\LayerFactory;
use Delta\Common\Interfaces\Processor as IProcessor;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use Delta\Components\Store\{Store, Enums\StoreType};

final class ImportLayer extends BaseSupportLayer implements ILayerProvider
{
    public function __construct(
        private readonly string|object $importedModule,
        private Container $container,
    ) {}

    public function process(): void
    {
        $layer = LayerFactory::createModuleLayer(
            $this->importedModule,
            $this->container,
        );

        $exports = $layer->getAttributeExports();

        $store = $this->container->resolve(Store::class);

        $store->setRecursive(
            $this->getParentModule(),
            StoreType::EXPORT,
            $exports,
        );

        $layer->process();
    }
}
