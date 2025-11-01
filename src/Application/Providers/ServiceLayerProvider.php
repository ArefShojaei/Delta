<?php

namespace Delta\Application\Providers;

use Delta\Application\Contracts\LayerProviderContract;


final class ServiceLayerProvider implements LayerProviderContract 
{
    public function __construct(private readonly string $module)
    {
    }

    public function process(): void
    {
    }
}
