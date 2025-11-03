<?php

namespace Delta\Components\Layer;

use Delta\Components\Layer\Interfaces\{
    Layer as ILayer, 
    LayerProvider as ILayerProvider
};
use Delta\Components\Layer\Enums\LayerType;


final class Layer implements ILayer
{
    private const NAMESPACE = "Delta\\Application\\Providers\\";

    private const PROVIDER_NAME = "LayerProvider";

    private ILayerProvider $layerProvider;


    public function __construct(LayerType $type, string $class)
    {
        $type = ucfirst($type->name);

        $layerProvider = "{$type}" . self::PROVIDER_NAME;

        $namespace = self::NAMESPACE . $layerProvider;

        $instance = new $namespace($class);

        $this->layerProvider = $instance;
    }

    public function get(): ILayerProvider
    {
        return $this->layerProvider;
    }
}
