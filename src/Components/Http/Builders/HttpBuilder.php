<?php

namespace Delta\Components\Http\Builders;

use Delta\Components\Routing\Router;
use Delta\Components\Http\{
    Response,
    Request,
    Http,
    Interfaces\HttpBuilder as IHttpBuilder,
};


final class HttpBuilder implements IHttpBuilder
{
    private Request $request;

    private Response $response;

    private Router $router;

    
    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function setRouter(Router $router): self
    {
        $this->router = $router;

        return $this;
    }

    public function build(): Http
    {
        return new Http($this->request, $this->response, $this->router);
    }
}
