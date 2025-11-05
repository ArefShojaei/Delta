<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Http\{Http, Request, Response};
use Delta\Components\Routing\Router;


interface HttpFactory
{
    public static function createRequest(array $headers): Request;

    public static function createResponse(): Response;

    public static function createHttp(
        Request $request,
        Response $response,
        Router $router,
    ): Http;
}
