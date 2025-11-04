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
