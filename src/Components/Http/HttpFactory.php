<?php

namespace Delta\Components\Http;

use Delta\Components\Http\Contracts\HttpFactoryContract;


final class HttpFactory implements HttpFactoryContract {
    public static function createRequest(array $headers): Request
    {
        return new Request($headers);
    }

    public static function createResponse(): Response
    {
        return new Response;
    }

    public static function createHttp(Request $request, Response $response, array $meta): Http {
        return new Http($request, $response, $meta);
    }
}