<?php

namespace Delta\Components\Layer;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Enums\LayerType;
use Delta\Components\Layer\Exceptions\InvalidLayerProviderException;
use Delta\Components\Layer\Interfaces\{
    Layer as ILayer,
    LayerProvider as ILayerProvider,
};

final class Layer implements ILayer
{
    private const NAMESPACE = "Delta\\Components\\Layer\\Support\\";

    private const SUFFIX_NAME = "Layer";

    private ILayerProvider $layerProvider;

    public function __construct(
        LayerType $type,
        string|object $class,
        Container $container,
    ) {
        $type = ucfirst($type->value);

        $layer = "{$type}" . self::SUFFIX_NAME;

        $namespace = self::NAMESPACE . $type . "\\" . $layer;

        if (!class_exists($namespace)) throw new InvalidLayerProviderException();

        $instance = new $namespace($class, $container);

        $this->layerProvider = $instance;
    }

    public function get(): ILayerProvider
    {
        return $this->layerProvider;
    }
}
