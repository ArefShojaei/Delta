<?php

namespace Delta\Providers;

use Delta\Components\Config\Config;
use Delta\Components\Env\DotEnvironment;
use Delta\Components\Container\Container;
use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;

final class DotEnvironmentServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(DotEnvironment::class, DotEnvironment::class);
    }

    public function boot(Container $container): void
    {
        $dotenv = $container->resolve(DotEnvironment::class);

        $path = Config::get("env.path");

        $dotenv->load($path);
    }
}
