<?php

namespace Delta\Components\Layer\Support\Provider;

use ReflectionClass;

use Delta\Components\Store\Store;
use Delta\Components\Container\Container;
use Delta\Components\Layer\Support\Provider\Abilities\CanResolveProvider;
use Delta\Components\Layer\{
    Attributes\Injectable,
    Interfaces\LayerProvider as ILayerProvider,
};

final class ProviderLayer implements ILayerProvider
{
    use CanResolveProvider;

    public function __construct(
        private readonly string|object $provider,
        private Container $container,
    ) {}

    public function process(): void
    {
        $providerReflection = new ReflectionClass($this->provider);

        if ($this->isInjected($providerReflection)) return;

        $store = $this->container->resolve(Store::class);

        $abstract = $this->getProviderLayerName(
            $this->getProviderName($providerReflection),
        );

        $store->addDependency($abstract, $providerReflection->newInstance());
    }

    private function isInjected(ReflectionClass $reflection): bool
    {
        $attributes = $reflection->getAttributes(Injectable::class);

        return empty($attributes);
    }
}
