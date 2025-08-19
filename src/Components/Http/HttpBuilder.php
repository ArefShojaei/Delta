<?php

namespace Delta\Components\Http;

use Delta\Components\Http\Contracts\HttpBuilderContract;
use Delta\Components\Http\Response;
use Delta\Components\Routing\Router;


final class HttpBuilder implements HttpBuilderContract {
    private Request $request;

    private Response $response;

    private Router $router;


    public function setRequest(): self {
        $this->request = new Request($_SERVER);

        return $this;
    }
    
    public function setResponse(): self {
        $this->response = new Response;
        
        return $this;
    }

    public function setRouter(Router $router): self {
        $this->router = $router;

        return $this;
    }

    public function build(): Http {
        return new Http($this->request, $this->response, [
            "router" => $this->router
        ]);
    }
}