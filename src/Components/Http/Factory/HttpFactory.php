<?php

namespace Delta\Components\Http\Factory;

use Delta\Components\Routing\Router;
use Delta\Components\Container\Container;
use Delta\Components\Http\{
    Http,
    Request,
    Response,
    Builders\HttpBuilder,
    Interfaces\HttpFactory as IHttpFactory,
};

final class HttpFactory implements IHttpFactory
{
    public static function createRequest(
        array $headers,
        Container $container,
    ): Request {
        return new Request($headers, $container);
    }

    public static function createResponse(): Response
    {
        return new Response();
    }

    public static function createHttp(
        Request $request,
        Response $response,
        Router $router,
    ): Http {
        return (new HttpBuilder())
            ->setRouter($router)
            ->setRequest($request)
            ->setResponse($response)
            ->build();
    }
}
