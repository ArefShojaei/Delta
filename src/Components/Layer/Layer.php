<?php

namespace Delta\Components\Layer;

use Delta\Components\Layer\Contracts\{
    LayerContract,
    LayerProviderContract
};
use Delta\Components\Layer\Enums\LayerTypeEnum;


final class Layer implements LayerContract
{
    private const NAMESPACE = "Delta\\Application\\Providers\\";
    
    private LayerProviderContract $layerProviderInstance;


    public function __construct(LayerTypeEnum $type, string $class)
    {
        $type = ucfirst($type->name);

        $layerProvider = "{$type}LayerProvider";

        $namespace = self::NAMESPACE . $layerProvider;
    
        $this->layerProviderInstance = new $namespace($class);
    }

    public function get(): LayerProviderContract {
        return $this->layerProviderInstance;
    }
}