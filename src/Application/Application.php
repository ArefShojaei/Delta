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


    public function __construct(private readonly string $appModule)
    {
        $this->router = new Router;

        $module = new ModuleLayerProvider($appModule, ["router" => $this->router]);
    
        $module->process();
    }

    public function run(): void
    {
        try {
            $httpBuilder = (new HttpBuilder)
                ->setRequest($_SERVER)
                ->setResponse()
                ->setRouter($this->router)
                ->build();

            $httpBuilder->listen();
        } catch (\Exception $e) {
            http_response_code(Response::HTTP_INTERNAL_SERVER_ERROR);

            echo json_encode([
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "error" => $e->getMessage(),
            ]);
        }
    }
}
