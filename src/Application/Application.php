<?php

namespace Delta\Application;

use Delta\Application\{
    Interfaces\Application as IApplication,
    Providers\ModuleLayerProvider,
};
use Delta\Components\Container\Container;
use Delta\Components\Http\Kernel;


final class Application implements IApplication
{
    public function __construct(string $module, private Container $container)
    {
        $moduleLayer = new ModuleLayerProvider($module);

        $moduleLayer->process();

        exit();
    }

    public function run(): void
    {
        $kernel = new Kernel($this->container);

        $kernel->handle();
    }
}
