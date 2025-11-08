<?php

namespace Delta\Components\Http;

use Delta\Components\{
    Http\Interfaces\Http as IHttp,
    Routing\Router
};


final class Http implements IHttp
{
    public function __construct(
        private Request $request,
        private Response $response,
        private Router $router,
    ) {}

    public static function getHeaders(): array
    {
        return $_SERVER;
    }

    public function listen(): void
    {
        $route = $this->router->findRoute(
            $this->request->method(),
            $this->request->route(),
        );

        $this->router->dispatch($route, [$this->request, $this->response]);
    }
}
