<?php

namespace Delta\Services;

use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;
use Delta\Components\Container\Container;
use Delta\Components\Env\DotEnvEnvironment as Env;
use Delta\Components\Http\{Http, Request, Response};
use Delta\Components\Http\Builders\HttpBuilder;
use Delta\Components\Routing\Router;


final class HttpServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Request::class, fn() => new Request($_SERVER));

        $container->bind(Response::class, Response::class);

        $container->bind(Http::class, function(Container $container) {
            return (new HttpBuilder)
                ->setRouter($container->resolve(Router::class))
                ->setRequest($container->resolve(Request::class))
                ->setResponse($container->resolve(Response::class))
                ->build();
        });
    }

    public function boot(Container $container): void {
        $response = $container->resolve(Response::class);

        $response->header("X-Powered-By", Env::get("APP_NAME", "Delta - PHP Framework"));
    }
}
