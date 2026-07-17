<?php

namespace Delta\Application;

use Delta\Bootstrap\Bootstrap;
use Delta\Components\Container\Container;
use Delta\Components\{Http\Kernel, Env\DotEnvEnvironment};
use Delta\Application\Exceptions\InvalidConfigurationExcepiton;
use Delta\Application\{
    Interfaces\Application as IApplication,
    Layers\LayerRegisteration,
};

final class Application implements IApplication
{
    use LayerRegisteration;

    private Bootstrap $bootstrap;

    public function __construct(private readonly string|object $module)
    {
        $this->bootstrap = new Bootstrap(new Container());
    }

    public function configure(array $config): self
    {
        if (empty($config)) {
            throw new InvalidConfigurationExcepiton("Config can not be empty!");
        }

        $dotenv = new DotEnvEnvironment();

        $dotenv->load($config["env_path"]);

        return $this;
    }

    private function boot(): void
    {
        $this->bootstrap->init();

        $this->registerModuleLayer();
    }

    public function run(): void
    {
        $this->boot();

        $kernel = new Kernel($this->bootstrap->getContainer());

        $kernel->handle();
    }
}
