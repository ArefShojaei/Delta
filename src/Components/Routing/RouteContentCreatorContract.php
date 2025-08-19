<?php

namespace Delta\Components\Routing;


interface RouteContentCreatorContract {
    public static function createFallback(): Route;
    public static function createUnsupportedMethod(string $method): void;
}