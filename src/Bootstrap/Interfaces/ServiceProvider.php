<?php

namespace Delta\Bootstrap\Interfaces;

use Delta\Components\Container\Container;


interface ServiceProvider
{
    public function register(Container $container): void;

    public function boot(Container $container): void;
}
