<?php

namespace Delta\Providers;

use Delta\Components\{Container\Container, Routing\Router};
use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;

final class RouterServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Router::class, Router::class);
    }

    public function boot(Container $container): void {}
}
