<?php

namespace Delta\Components\Layer;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Interfaces\{
    LayerFactory as ILayerFactory,
    LayerProvider as ILayerProvider,
};
use Delta\Components\Layer\Enums\LayerType;


final class LayerFactory implements ILayerFactory
{
    public static function createModuleLayer(string $class, Container $container): ILayerProvider
    {
        return (new Layer(LayerType::MODULE, $class, $container))->get();
    }

    public static function createControllerLayer(string $class, Container $container): ILayerProvider
    {
        return (new Layer(LayerType::CONTROLLER, $class, $container))->get();
    }

    public static function createProviderLayer(string $class, Container $container): ILayerProvider
    {
        return (new Layer(LayerType::SERVICE, $class, $container))->get();
    }
}
