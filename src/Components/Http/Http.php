<?php

namespace Delta\Components\Http;

use Delta\Components\{
    Http\Interfaces\Http as IHttp,
    Routing\Router
};


final class Http implements IHttp
{
    private Router $router;

    
    public function __construct(
        private Request $request,
        private Response $response,
        private array $meta,
    ) {
        $this->router = $meta["router"];
    }

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

        if ($route->path !== $this->request->route()) {
            http_response_code(404);

            echo $this->router->execute($route, []);

            return;
        }

        echo $this->router->execute($route, [$this->request, $this->response]);
    }
}
