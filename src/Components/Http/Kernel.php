<?php

namespace Delta\Components\Http;

use Delta\Components\Container\Container;
use Delta\Components\Http\Builders\{HttpBuilder, ResponseBuilder};
use Delta\Components\Http\Interfaces\Kernel as IKernel;


final class Kernel implements IKernel
{
    public function __construct(private Container $container) {}

    public function handle(): void
    {
        try {
            $http = new HttpBuilder()
                ->setRouter($this->container->resolve("router"))
                ->setRequest(Http::getHeaders())
                ->setResponse()
                ->build();

            $http->listen();
        } catch (\Exception $e) {
            $body = [
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "message" => $e->getMessage(),
            ];

            $response = new ResponseBuilder()
                ->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->setHeader("Content-type", "application/json")
                ->setBody($body)
                ->build();

            $response->send();
        }
    }
}
