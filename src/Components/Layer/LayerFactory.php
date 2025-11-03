<?php

namespace Delta\Components\Layer;

use Delta\Components\Layer\Interfaces\{
    LayerFactory as ILayerFactory,
    LayerProvider as ILayerProvider,
};
use Delta\Components\Layer\Enums\LayerType;


final class LayerFactory implements ILayerFactory
{
    public static function createModuleLayer(string $class): ILayerProvider
    {
        return (new Layer(LayerType::MODULE, $class))->get();
    }

    public static function createControllerLayer(string $class): ILayerProvider
    {
        return (new Layer(LayerType::CONTROLLER, $class))->get();
    }

    public static function createServiceLayer(string $class): ILayerProvider
    {
        return (new Layer(LayerType::SERVICE, $class))->get();
    }
}
