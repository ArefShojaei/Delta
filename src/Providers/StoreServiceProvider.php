<?php

namespace Delta\Providers;

use Delta\Components\Store\Store;
use Delta\Components\Container\Container;
use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;

final class StoreServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Store::class, Store::class);
    }

    public function boot(Container $container): void {}
}
