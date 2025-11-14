<?php

namespace Delta\Application;

use Delta\Application\Interfaces\DeltaFactory as IDeltaFactory;


final class DeltaFactory implements IDeltaFactory
{
    public static function createApp(string|object $module): Application
    {
        return new Application($module);
    }
}
