<?php

namespace Delta\Application;

use Delta\Application\{
    Contracts\LayerProviderContract,
    Enums\LayerTypeEnum
};


final class Layer
{
    private LayerProviderContract $layerProviderInstance;


    public function __construct(LayerTypeEnum $type, string $class)
    {
        $type = ucfirst($type->name);

        $layerProvider = "{$type}LayerProvider";

        $namespace = "Delta\\Application\\Providers\\" . $layerProvider;
    
        $this->layerProviderInstance = new $namespace($class);
    }

    public function get(): LayerProviderContract {
        return $this->layerProviderInstance;
    }
}