<?php

namespace Delta\Application\Layers\Provider;

use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;


final class ProviderLayer implements ILayerProvider
{
    public function __construct(private readonly string $module) {}

    public function process(): void {}
}
