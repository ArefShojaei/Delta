<?php

namespace Delta\Application\Contracts;

use Delta\Application\Application;


interface DeltaFactoryContract {
    public static function createApp(string $appModule): Application;
}