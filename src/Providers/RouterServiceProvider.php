<?php

namespace Delta\Providers;

use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;
use Delta\Components\{
    Container\Container,
    Routing\Router
};


final class RouterServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Router::class, Router::class);
    }

    public function boot(Container $container): void {}
}
