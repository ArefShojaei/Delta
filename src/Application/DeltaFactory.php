<?php

namespace Delta\Application;

use Delta\Application\Contracts\DeltaFactoryContract;


final class DeltaFactory implements DeltaFactoryContract
{
    public static function createApp(string $appModule): Application
    {
        return new Application($appModule);
    }
}
