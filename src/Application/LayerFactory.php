<?php

namespace Delta\Application;

use Delta\Application\Contracts\LayerProviderContract;
use Delta\Application\Enums\LayerTypeEnum;


final class LayerFactory
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