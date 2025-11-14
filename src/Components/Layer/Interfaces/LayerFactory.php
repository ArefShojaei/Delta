<?php

namespace Delta\Components\Layer\Interfaces;

use Delta\Components\Container\Container;


interface LayerFactory
{
    public static function createModuleLayer(string|object $module, Container $container): LayerProvider;

    public static function createControllerLayer(string|object $controller, Container $container): LayerProvider;

    public static function createProviderLayer(string|object $provider, Container $container): LayerProvider;
}
