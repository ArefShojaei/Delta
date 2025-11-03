<?php

namespace Delta\Application;

use Delta\Application\{
    Interfaces\Application as IApplication,
    Providers\ModuleLayerProvider
};
use Delta\Components\Http\{
    Http,
    Response,
    Builders\ResponseBuilder,
    Builders\HttpBuilder,
};
use Delta\Components\Routing\Router;


final class Application implements IApplication
{
    private Router $router;


    public function __construct(string $module, private readonly array $meta)
    {
        $this->router = $meta["router"];

        $moduleLayer = new ModuleLayerProvider($module);

        $moduleLayer->process();

        exit;
    }

    public function run(): void
    {
        try {
            $http = (new HttpBuilder())
                ->setRouter($this->router)
                ->setRequest(Http::getHeaders())
                ->setResponse()
                ->build();

            $http->listen();
        } catch (\Exception $e) {
            $body = [
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "message" => $e->getMessage(),
            ];

            $response = (new ResponseBuilder)
                ->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
                ->setHeader("Content-type", "application/json")
                ->setBody($body)
                ->build();

            $response->send();
        }
    }
}
