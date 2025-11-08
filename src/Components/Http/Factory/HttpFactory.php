<?php

namespace Delta\Components\Http\Factory;

use Delta\Components\Http\{
    Interfaces\HttpFactory as IHttpFactory,
    Builders\HttpBuilder,
    Http,
    Request,
    Response,
};
use Delta\Components\Routing\Router;


final class HttpFactory implements IHttpFactory
{
    /**
     * @param array $headers Http headers
     */
    public static function createRequest(array $headers): Request
    {
        return new Request($headers);
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
        return (new HttpBuilder)
            ->setRouter($router)
            ->setRequest($request)
            ->setResponse($response)
            ->build();
    }
}
