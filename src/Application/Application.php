<?php

namespace Delta\Application;

use Delta\Bootstrap\Bootstrap;
use Delta\Components\Container\Container;
use Delta\Components\Layer\LayerRegistry;
use Delta\Components\{Http\Kernel, Env\DotEnvironment};
use Delta\Application\Interfaces\Application as IApplication;
use Delta\Application\Exceptions\InvalidConfigurationExcepiton;

final class Application extends LayerRegistry implements IApplication
{
    private Bootstrap $bootstrap;

    public function __construct(
        private readonly string|object $module,
        private Container $container,
    ) {
        parent::__construct($this->container);

        $this->bootstrap = new Bootstrap($this->container);
    }

    public function configure(array $config): self
    {
        if (empty($config)) {
            throw new InvalidConfigurationExcepiton("Config can not be empty!");
        }

        $dotenv = new DotEnvironment();

        $dotenv->load($config["env"]["path"]);

        return $this;
    }

    private function boot(): void
    {
        $this->bootstrap->init();

        $this->register($this->module);
    }

    public function run(): void
    {
        $this->boot();

        $kernel = new Kernel($this->container);

        $kernel->handle();
    }
}
