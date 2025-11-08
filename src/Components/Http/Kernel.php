<?php

namespace Delta\Components\Http;

use Delta\Components\Container\Container;
use Delta\Components\Http\Interfaces\Kernel as IKernel;


final class Kernel implements IKernel
{
    public function __construct(private Container $container) {}

    public function handle(): void
    {
        $http = $this->container->resolve(Http::class);

        $http->listen();
    }
}
