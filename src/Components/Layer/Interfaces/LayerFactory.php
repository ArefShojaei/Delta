<?php

namespace Delta\Components\Layer\Interfaces;


interface LayerFactory
{
    public static function createModuleLayer(string $class): LayerProvider;
    
    public static function createControllerLayer(string $class): LayerProvider;
    
    public static function createServiceLayer(string $class): LayerProvider;
}
