<?php

namespace Delta\Application\Providers;

use Delta\Application\Contracts\LayerProviderContract;


final class ControllerLayerProvider implements LayerProviderContract 
{
    public function __construct(private readonly string $module)
    {
    }

    public function process(): void
    {
    }
}
