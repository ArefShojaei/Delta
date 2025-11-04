<?php

namespace Delta\Application\Interfaces;

use Delta\Application\Application;
use Delta\Components\Container\Container;


interface DeltaFactory
{
    public static function createApp(
        string $module,
        Container $container,
    ): Application;
}
