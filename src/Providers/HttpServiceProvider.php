<?php

namespace Delta\Providers;

use Delta\Components\Routing\Router;
use Delta\Components\Container\Container;
use Delta\Components\Http\Factory\HttpFactory;
use Delta\Components\Http\{Http, Request, Response};
use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;

final class HttpServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            Request::class,
            fn() => HttpFactory::createRequest($_SERVER, $container),
        );

        $container->bind(
            Response::class,
            fn() => HttpFactory::createResponse(),
        );

        $container->bind(Http::class, function (Container $container) {
            return HttpFactory::createHttp(
                router: $container->resolve(Router::class),
                request: $container->resolve(Request::class),
                response: $container->resolve(Response::class),
            );
        });
    }

    public function boot(Container $container): void
    {
        $http = $container->resolve(Http::class);

        $config = require config_path() . "/app.php";

        $http->applyMiddlewares($config["middlewares"]);
    }
}
