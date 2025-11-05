<?php

namespace Delta\Bootstrap;

use Delta\Bootstrap\Interfaces\Bootstrap as IBootstrap;
use Delta\Components\Container\Container;


final class Bootstrap implements IBootstrap
{
    private ?Container $container;


    public function init(): void
    {
        $this->buildContainer();

        $this->registerServiceProviders();
    }

    private function registerServiceProviders(): void
    {
        $serviceFiles = glob(dirname(__DIR__) . "\\services\\*.php");

        foreach ($serviceFiles as $serviceFile) {
            $pathParts = explode("\\", $serviceFile);

            $file = end($pathParts);

            $name = trim(str_replace(".php", "", $file));

            $service = "Delta\\Services\\" . ucfirst($name);

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
