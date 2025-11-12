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
        $container->bind(Router::class, fn(Container $container) => new Router($container));
    }

    public function boot(Container $container): void {}
}
