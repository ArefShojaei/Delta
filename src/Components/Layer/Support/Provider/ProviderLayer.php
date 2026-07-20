<?php

namespace Delta\Components\Layer\Support\Provider;

use ReflectionClass;

use Delta\Components\Container\Container;
use Delta\Components\Store\{Store, Enums\StoreType};
use Delta\Components\Layer\{BaseSupportLayer, Attributes\Injectable};
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;

final class ProviderLayer extends BaseSupportLayer implements ILayerProvider
{
    public function __construct(
        private readonly string|object $provider,
        private Container $container,
    ) {}

    public function process(): void
    {
        $providerReflection = new ReflectionClass($this->provider);

        if ($this->isInjected($providerReflection)) return;

        $store = $this->container->resolve(Store::class);

        $store->set(
            $this->getParentModule(),
            StoreType::PROVIDER,
            $providerReflection->newInstance(),
        );
    }

    private function isInjected(ReflectionClass $reflection): bool
    {
        $attributes = $reflection->getAttributes(Injectable::class);

        return empty($attributes);
    }
}
