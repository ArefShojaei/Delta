<?php

namespace Delta\Bootstrap;

use RuntimeException;

use Delta\Components\Container\Container;
use Delta\Bootstrap\Exceptions\InvalidServiceProviderException;
use Delta\Bootstrap\Interfaces\{ServiceProvider, Bootstrap as IBootstrap};

final class Bootstrap implements IBootstrap
{
    public function __construct(private Container $container) {}

    public function init(): void
    {
        $this->registerServiceProviders();
    }

    private function registerServiceProviders(): void
    {
        $file = dirname(__DIR__) . "/config/app.php";

        if (!is_file($file)) {
            throw new RuntimeException("Configuration file not found: {$file}");
        }

        $config = require_once $file;

        $services = $config["providers"];

        if (empty($services)) return;

        foreach ($services as $service) {
            $instance = new $service();

            if (
                !is_object($instance) &&
                !($instance instanceof ServiceProvider)
            ) {
                throw new InvalidServiceProviderException();
            }

            $instance->register($this->getContainer());

            $instance->boot($this->getContainer());
        }
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
}
