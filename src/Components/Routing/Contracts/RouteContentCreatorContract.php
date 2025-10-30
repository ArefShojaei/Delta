<?php

namespace Delta\Components\Routing\Contracts;

use Delta\Components\Routing\Route;


interface RouteContentCreatorContract {
    public static function createFallback(): Route;
    public static function createUnsupportedMethod(string $method): string;
}