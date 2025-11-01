<?php

namespace Delta\Application;

use Delta\Application\Contracts\ApplicationContract;
use Delta\Application\Providers\ModuleLayerProvider;
use Delta\Components\Routing\Router;
use Delta\Components\Http\HttpBuilder;
use Delta\Components\Http\Response;


final class Application implements ApplicationContract
{
    private Router $router;
    
    private HttpBuilder $httpBuilder;

    private array $httpHeaders;


    public function __construct(string $module, private readonly array $meta)
    {
        $this->router = $meta["router"];

        $this->httpBuilder = $meta["http"]["builder"];
        
        $this->httpHeaders = $meta["http"]["headers"];
    
        $moduleLayer = new ModuleLayerProvider($module);
    
        $moduleLayer->process();
        
        exit;
    }

    public function run(): void
    {
        try {
            $http = $this->httpBuilder
                ->setRouter($this->router)
                ->setRequest($this->httpHeaders)
                ->setResponse()
                ->build();

            $http->listen();
        } catch (\Exception $e) {
            http_response_code(Response::HTTP_INTERNAL_SERVER_ERROR);

            echo json_encode([
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "error" => $e->getMessage(),
            ]);
        }
    }
}
