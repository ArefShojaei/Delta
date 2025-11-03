<?php

namespace Delta\Components\Http;

use Delta\Components\Http\Interfaces\HttpFactory as IHttpFactory;


final class HttpFactory implements IHttpFactory
{
    public static function createRequest(array $headers): Request
    {
        return new Request($headers);
    }

    public static function createResponse(): Response
    {
        return new Response;
    }

    public static function createHttp(Request $request, Response $response, array $meta): Http
    {
        return new Http($request, $response, $meta);
    }
}