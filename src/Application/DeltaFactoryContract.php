<?php

namespace Delta\Application;


interface DeltaFactoryContract {
    public static function createApp(string $appModule): Application;
}