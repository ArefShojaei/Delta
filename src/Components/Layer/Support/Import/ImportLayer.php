<?php

namespace Delta\Components\Layer\Support\Import;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;

final class ImportLayer implements ILayerProvider
{
    public function __construct(
        private readonly string|object $module,
        private Container $container,
    ) {}

    public function process(): void {}
}
