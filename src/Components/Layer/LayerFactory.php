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
    public static function createModuleLayer(string $module, Container $container): ILayerProvider
    {
        return (new Layer(LayerType::MODULE, $module, $container))->get();
    }

    public static function createControllerLayer(string $controller, Container $container): ILayerProvider
    {
        return (new Layer(LayerType::CONTROLLER, $controller, $container))->get();
    }

    public static function createProviderLayer(string $provider, Container $container): ILayerProvider
    {
        return (new Layer(LayerType::PROVIDER, $provider, $container))->get();
    }
}
