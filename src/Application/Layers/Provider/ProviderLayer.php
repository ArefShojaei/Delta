<?php

namespace Delta\Application\Layers\Provider;

use ReflectionClass;
use Delta\Components\Container\Container;
use Delta\Application\Layers\Provider\Abilities\CanResolveProvider;
use Delta\Store\LayerStore;
use Delta\Components\Layer\{
    Attributes\Injectable,
    Interfaces\LayerProvider as ILayerProvider
};


final class ProviderLayer implements ILayerProvider
{
    use CanResolveProvider;


    public function __construct(private readonly string|object $provider,private Container $container) {}

    public function process(): void
    {
        $providerReflection = new ReflectionClass($this->provider);

        if ($this->isInjected($providerReflection)) return;


        $layerStore = $this->container->resolve(LayerStore::class);

        $abstract = $this->getProviderLayerName($this->getProviderName($providerReflection));

        $layerStore->addDependency($abstract, $providerReflection->newInstance());
    }

    private function isInjected(ReflectionClass $reflection): bool
    {
        $attributes = $reflection->getAttributes(Injectable::class);

        return empty($attributes);
    }
}
