<?php

namespace Delta\Components\Layer\Factory;

use Delta\Components\Container\Container;
use Delta\Components\Layer\{Layer, Enums\LayerType};
use Delta\Components\Layer\Interfaces\{
    LayerFactory as ILayerFactory,
    LayerProvider as ILayerProvider,
};

final class LayerFactory implements ILayerFactory
{
    public static function createModuleLayer(
        string|object $module,
        Container $container,
    ): ILayerProvider {
        return self::createLayer(LayerType::MODULE, $module, $container);
    }

    public static function createControllerLayer(
        string|object $controller,
        Container $container,
    ): ILayerProvider {
        return self::createLayer(
            LayerType::CONTROLLER,
            $controller,
            $container,
        );
    }

    public static function createProviderLayer(
        string|object $provider,
        Container $container,
    ): ILayerProvider {
        return self::createLayer(LayerType::PROVIDER, $provider, $container);
    }

    public static function createImportLayer(
        string|object $module,
        Container $container,
    ): ILayerProvider {
        return self::createLayer(LayerType::IMPORT, $module, $container);
    }

    public static function createExportLayer(
        string|object $provider,
        Container $container,
    ): ILayerProvider {
        return self::createLayer(LayerType::EXPORT, $provider, $container);
    }

    private static function createLayer(
        LayerType $type,
        string|object $layer,
        Container $container,
    ): ILayerProvider {
        $layer = new Layer($type, $layer, $container);

        return $layer->get();
    }
}
