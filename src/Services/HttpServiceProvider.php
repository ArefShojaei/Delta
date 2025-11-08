<?php

namespace Delta\Services;

use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;
use Delta\Components\Container\Container;
use Delta\Components\Env\DotEnvEnvironment as Env;
use Delta\Components\Http\{Http, Request, Response};
use Delta\Components\Http\Factory\HttpFactory;
use Delta\Components\Routing\Router;


final class HttpServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Request::class, fn() => HttpFactory::createRequest($_SERVER));

        $container->bind(Response::class, fn() => HttpFactory::createResponse());

        $container->bind(Http::class, function(Container $container) {
            return HttpFactory::createHttp(
                router: $container->resolve(Router::class),
                request: $container->resolve(Request::class),
                response: $container->resolve(Response::class),
            );
        });
    }

    public function boot(Container $container): void {
        $response = $container->resolve(Response::class);

        $response->header("X-Powered-By", Env::get("APP_NAME", "Delta - PHP Framework"));
    }
}
