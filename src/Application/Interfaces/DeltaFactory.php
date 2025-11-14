<?php

namespace Delta\Application\Interfaces;

use Delta\Application\Application;


interface DeltaFactory
{
    public static function createApp(string|object $module): Application;
}
