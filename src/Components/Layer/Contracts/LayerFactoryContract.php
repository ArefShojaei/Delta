<?php

namespace Delta\Components\Layer\Contracts;


interface LayerFactoryContract
{
    public static function createModuleLayer(string $class): LayerProviderContract;
    public static function createControllerLayer(string $class): LayerProviderContract;
    public static function createServiceLayer(string $class): LayerProviderContract;
}