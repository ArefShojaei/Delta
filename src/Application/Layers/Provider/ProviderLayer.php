<?php

namespace Delta\Application\Layers\Provider;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Attributes\Injectable;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;
use ReflectionClass;


final class ProviderLayer implements ILayerProvider
{
    public function __construct(private readonly string $provider, private Container $container) {}

    public function process(): void
    {
        $providerReflection = new ReflectionClass($this->provider);

        if ($this->isInjected($providerReflection)) return;
    }

    private function isInjected(ReflectionClass $reflection): bool
    {
        $attributes = $reflection->getAttributes(Injectable::class);

        return empty($attributes);
    }
}
