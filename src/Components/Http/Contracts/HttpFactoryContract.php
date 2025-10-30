<?php

namespace Delta\Components\Http\Contracts;

use Delta\Components\Http\{
    Http,
    Request,
    Response
};


interface HttpFactoryContract
{
    public static function createRequest(array $headers): Request;
    public static function createResponse(): Response;
    public static function createHttp(Request $request, Response $response, array $meta): Http;
}
