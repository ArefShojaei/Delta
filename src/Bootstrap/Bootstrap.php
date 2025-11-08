<?php

namespace Delta\Bootstrap;

use Delta\Bootstrap\Interfaces\Bootstrap as IBootstrap;
use Delta\Components\Container\Container;
use Delta\Components\Env\DotEnvEnvironment;


final class Bootstrap implements IBootstrap
{
    private ?Container $container;


    public function init(): void
    {
        (new DotEnvEnvironment)->load(dirname(__DIR__, 2));

        $this->buildContainer();

        $this->registerServiceProviders();
    }

    private function registerServiceProviders(): void
    {
        $app = require_once dirname(__DIR__) . "/config/app.php";

        $services = $app["providers"];

        foreach ($services as $service) {
            $instance = new $service;

            $instance->register($this->getContainer());

            $instance->boot($this->getContainer());
        }
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    private function buildContainer(): void
    {
        $this->container = new Container();
    }
}
