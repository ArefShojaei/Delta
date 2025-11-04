<?php

namespace Delta\Application;

use Delta\Application\Interfaces\DeltaFactory as IDeltaFactory;
use Delta\Components\Container\Container;


final class DeltaFactory implements IDeltaFactory
{
    public static function createApp(
        string $module,
        Container $container,
    ): Application {
        return new Application($module, $container);
    }
}
