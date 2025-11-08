<?php

namespace Delta\Services;

use Delta\Bootstrap\Interfaces\ServiceProvider as IServiceProvider;
use Delta\Components\Container\Container;
use Delta\Components\Http\{Http, Request, Response};
use Delta\Components\Routing\Router;


final class HttpServiceProvider implements IServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(Request::class, fn() => new Request($_SERVER));

        $container->bind(Response::class, Response::class);

        $container->bind(Http::class, function (Container $container) {
            return new Http(
                request: $container->resolve(Request::class),
                response: $container->resolve(Response::class),
                router: $container->resolve(Router::class),
            );
        });
    }

    public function boot(Container $container): void {
        $response = $container->resolve(Response::class);

        $response->header("X-Powered-By", "Delta - PHP Framework");
    }
}
