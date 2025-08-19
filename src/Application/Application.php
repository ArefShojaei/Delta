<?php

namespace Delta\Application;

use Delta\Application\Contracts\ApplicationContract;
use Delta\Application\Providers\ModuleLayerProvider;
use Delta\Components\Routing\Router;
use Delta\Components\Http\HttpBuilder;


final class Application implements ApplicationContract
{
    private Router $router;


    public function __construct(private string $app)
    {

        $this->router = new Router;

        $module = new ModuleLayerProvider($app, ["router" => $this->router]);
    
        $module->process();
    }

    public function run(): void
    {
        $httpBuilder = (new HttpBuilder)
            ->setRequest()
            ->setResponse()
            ->setRouter($this->router)
            ->build();

        $httpBuilder->listen();
    }
}
