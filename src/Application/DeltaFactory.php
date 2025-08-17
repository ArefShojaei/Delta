<?php

namespace Delta\Application;


final class DeltaFactory implements DeltaFactoryContract
{
    public static function createApp(string $appModule): Application
    {
        return new Application($appModule);
    }
}
