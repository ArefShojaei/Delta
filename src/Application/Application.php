<?php

namespace Delta\Application;

use Delta\Application\{
    Interfaces\Application as IApplication,
    Layers\HasLayerProviderRegisteration
};
use Delta\Bootstrap\Bootstrap;
use Delta\Components\Http\Kernel;


final class Application implements IApplication
{
    use HasLayerProviderRegisteration;

    private Bootstrap $bootstrap;


    public function __construct(private readonly string $module)
    {
        $this->bootstrap = new Bootstrap;
    }

    public function boot(): void
    {
        $this->bootstrap->init();

        $this->registerLayerProviders();
    }

    public function run(): void
    {
        $kernel = new Kernel($this->bootstrap->getContainer());

        $kernel->handle();
    }
}
