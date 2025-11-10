<?php

namespace Delta\Components\Layer\Interfaces;

use Delta\Components\Container\Container;


interface LayerFactory
{
    public static function createModuleLayer(string $class, Container $container): LayerProvider;

    public static function createControllerLayer(string $class, Container $container): LayerProvider;

    public static function createProviderLayer(string $class, Container $container): LayerProvider;
}
