<?php

namespace Delta\Components\Layer\Interfaces;

use Delta\Components\Container\Container;


interface LayerFactory
{
    public static function createModuleLayer(string $module, Container $container): LayerProvider;

    public static function createControllerLayer(string $controller, Container $container): LayerProvider;

    public static function createProviderLayer(string $provider, Container $container): LayerProvider;
}
