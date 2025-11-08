<?php

namespace Delta\Components\Http;

use Delta\Components\Container\Container;
use Delta\Components\Routing\Router;
use Delta\Components\Http\{
    Builders\HttpBuilder,
    Interfaces\Kernel as IKernel
};


final class Kernel implements IKernel
{
    public function __construct(private Container $container) {}

    public function handle(): void
    {
        $http = (new HttpBuilder)
            ->setRouter($this->container->resolve(Router::class))
            ->setRequest(Http::getHeaders())
            ->setResponse()
            ->build();

        $http->listen();
    }
}
