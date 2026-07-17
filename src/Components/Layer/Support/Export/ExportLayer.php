<?php

namespace Delta\Components\Layer\Support\Export;

use ReflectionClass;

use Delta\Components\Store\Store;
use Delta\Components\Container\Container;
use Delta\Components\Layer\Attributes\Injectable;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use Delta\Components\Layer\Support\Export\Abilities\CanResolveExportProvider;

final class ExportLayer implements ILayerProvider
{
    use CanResolveExportProvider;

    public function __construct(
        private readonly string|object $provider,
        private Container $container,
    ) {}

    public function process(): void
    {
        $providerReflection = new ReflectionClass($this->provider);

        if ($this->isInjected($providerReflection)) return;

        $store = $this->container->resolve(Store::class);

        $abstract = $this->getExportProviderLayerName(
            $this->getExportProviderName($providerReflection),
        );

        $store->addDependency(
            $abstract,
            $providerReflection->newInstance(),
        );
    }

    private function isInjected(ReflectionClass $reflection): bool
    {
        $attributes = $reflection->getAttributes(Injectable::class);

        return empty($attributes);
    }
}
