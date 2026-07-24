<?php

namespace Delta\Providers;

use Delta\Components\Logging\Logger;
use Delta\Components\Container\Container;
use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;

final class LoggingServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->singleton(Logger::class, Logger::class);
    }

    public function boot(Container $container): void {}
}
