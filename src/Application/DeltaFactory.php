<?php

namespace Delta\Application;

use Delta\Application\Exceptions\InvalidModuleException;
use Delta\Application\Interfaces\DeltaFactory as IDeltaFactory;

final class DeltaFactory implements IDeltaFactory
{
    public static function createApp(string|object $module): Application
    {
        if (empty($module) || !isset($module)) {
            throw new InvalidModuleException("Root module not set!");
        }

        return new Application($module);
    }
}
