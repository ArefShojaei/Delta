<?php

namespace Delta\Application\Providers;

use Delta\Application\Interfaces\LayerProvider as ILayerProvider;


final class ControllerLayerProvider implements ILayerProvider 
{
    public function __construct(private readonly string $module)
    {
    }

    public function process(): void
    {
    }
}
