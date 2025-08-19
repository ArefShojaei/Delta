<?php

namespace Delta\Components\Routing;

use Delta\Components\Http\Request;


final class RouteContentCreator implements RouteContentCreatorContract
{
    public static function createFallback(): Route
    {
        return new Route(
            method: Request::READABLE,
            path: "/404",
            callback: fn () => "404 | Not Found"
        );
    }

    public static function createUnsupportedMethod(string $method): void
    {
        $message = "[ERROR] Unsupported \"{$method}\" Http method!";

        die($message);
    }
}
