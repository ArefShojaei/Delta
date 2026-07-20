<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Routing\Router;
use Delta\Components\Container\Container;
use Delta\Components\Http\{Http, Request, Response};

interface HttpFactory
{
    public static function createRequest(
        array $headers,
        Container $container,
    ): Request;

    public static function createResponse(): Response;

    public static function createHttp(
        Request $request,
        Response $response,
        Router $router,
    ): Http;
}
