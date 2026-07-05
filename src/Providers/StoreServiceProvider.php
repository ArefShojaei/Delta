<?php

namespace Delta\Providers;

use Delta\Store\LayerStore;
use Delta\Components\Container\Container;
use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;

final class StoreServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(LayerStore::class, LayerStore::class);
    }

    public function boot(Container $container): void {}
}
