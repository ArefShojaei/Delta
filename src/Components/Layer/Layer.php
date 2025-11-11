<?php

namespace Delta\Components\Layer;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Interfaces\{
    Layer as ILayer,
    LayerProvider as ILayerProvider
};
use Delta\Components\Layer\Enums\LayerType;


final class Layer implements ILayer
{
    private const PROVIDERS_NAMESPACE = "Delta\\Application\\Layers\\";

    private const PROVIDER_SUFFIX_NAME = "Layer";

    private ILayerProvider $layerProvider;


    public function __construct(LayerType $type, string $class, Container $container)
    {
        $type = ucfirst($type->value);

        $layerProvider = "{$type}" . self::PROVIDER_SUFFIX_NAME;

        $namespace = self::PROVIDERS_NAMESPACE . $type . "\\" . $layerProvider;

        $instance = new $namespace($class, $container);

        $this->layerProvider = $instance;
    }

    public function get(): ILayerProvider
    {
        return $this->layerProvider;
    }
}
