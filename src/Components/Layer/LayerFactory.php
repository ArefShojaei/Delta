<?php

namespace Delta\Components\Layer;

use Delta\Components\Layer\Contracts\{
    LayerFactoryContract,
    LayerProviderContract
};
use Delta\Components\Layer\Enums\LayerTypeEnum;


final class LayerFactory implements LayerFactoryContract
{
    public static function createModuleLayer(string $class): LayerProviderContract
    {
        return (new Layer(LayerTypeEnum::MODULE, $class))->get();
    }
    
    public static function createControllerLayer(string $class): LayerProviderContract
    {
        return (new Layer(LayerTypeEnum::CONTROLLER, $class))->get();
    }
    
    public static function createServiceLayer(string $class): LayerProviderContract
    {
        return (new Layer(LayerTypeEnum::SERVICE, $class))->get();
    }
}