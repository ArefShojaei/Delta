<?php

namespace Delta\Components\Layer\Support\Export;

use Delta\Components\Container\Container;
use Delta\Components\Layer\BaseSupportLayer;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;

final class ExportLayer extends BaseSupportLayer implements ILayerProvider
{
    public function __construct(
        private readonly string|object $provider,
        private Container $container,
    ) {}

    public function process(): void {}
}
