<?php

namespace Delta\Application;

use Delta\Application\Contracts\DeltaFactoryContract;
use Delta\Components\{
    Http\HttpBuilder,
    Routing\Router
};


final class DeltaFactory implements DeltaFactoryContract
{
    public static function createApp(string $appModule): Application
    {
        $meta = [
            "router" => new Router,
            "http" => [
                "headers" => $_SERVER,
                "builder" => new HttpBuilder
            ]
        ];

        return new Application($appModule, $meta);
    }
}
