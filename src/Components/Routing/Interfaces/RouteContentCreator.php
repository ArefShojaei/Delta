<?php

namespace Delta\Components\Routing\Interfaces;

use Delta\Components\Routing\Route;


interface RouteContentCreator
{
    public static function createFallback(): Route;
    
    public static function createUnsupportedMethod(string $method): string;
}
