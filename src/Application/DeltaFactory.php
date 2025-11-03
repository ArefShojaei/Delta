<?php

namespace Delta\Application;

use Delta\Application\Interfaces\DeltaFactory as IDeltaFactory;
use Delta\Components\Routing\Router;


final class DeltaFactory implements IDeltaFactory
{
    public static function createApp(string $appModule): Application
    {
        $meta = [
            "router" => new Router(),
        ];

        return new Application($appModule, $meta);
    }
}
