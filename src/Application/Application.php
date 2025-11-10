<?php

namespace Delta\Application;

use Delta\Application\{
    Interfaces\Application as IApplication,
    Layers\LayerRegisteration
};
use Delta\Bootstrap\Bootstrap;
use Delta\Components\Env\DotEnvEnvironment;
use Delta\Components\Http\Kernel;


final class Application implements IApplication
{
    use LayerRegisteration;

    private Bootstrap $bootstrap;


    public function __construct(private readonly string $module)
    {
        $this->bootstrap = new Bootstrap;
    }

    public function configure(array $config): self
    {
        (new DotEnvEnvironment)->load($config["env_path"]);

        return $this;
    }

    private function boot(): void
    {
        $this->bootstrap->init();

        $this->registerLayers();
    }

    public function run(): void
    {
        $this->boot();

        $kernel = new Kernel($this->bootstrap->getContainer());

        $kernel->handle();
    }
}
