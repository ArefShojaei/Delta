<?php

namespace Delta\Components\Http;

use Delta\Components\Routing\Router;


final class Http
{
    private Router $router;

    public function __construct(
        private Request $request,
        private Response $response,
        private array $meta
    ) {
        $this->router = $meta["router"];
    }

    public function listen() {
        $route = $this->router->findRoute(
            $this->request->method(),
            $this->request->route()
        );

        if (is_null($route) | !$route) {
            echo "404 | Not Found";
            
            return;
        }

        echo $this->router->execute($route, [$this->request, $this->response]);
    }
}
