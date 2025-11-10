<?php

namespace Delta\Application\Layers\Controller;

use Delta\Components\Layer\Interfaces\LayerProvider as ILayerProvider;


final class ControllerLayer implements ILayerProvider
{
    public function __construct(private readonly string $module) {}

    public function process(): void {}
}
