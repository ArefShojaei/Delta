<?php

namespace Delta\Components\Http\Builders;

use Delta\Components\Routing\Router;
use Delta\Components\Http\{
    Response,
    Request,
    Http,
    Factory\HttpFactory,
    Interfaces\HttpBuilder as IHttpBuilder,
};


final class HttpBuilder implements IHttpBuilder
{
    private Request $request;

    private Response $response;

    private Router $router;

    
    public function setRequest(array $headers): self
    {
        $this->request = HttpFactory::createRequest($headers);

        return $this;
    }

    public function setResponse(): self
    {
        $this->response = HttpFactory::createResponse();

        return $this;
    }

    public function setRouter(Router $router): self
    {
        $this->router = $router;

        return $this;
    }

    public function build(): Http
    {
        return HttpFactory::createHttp($this->request, $this->response, $this->router);
    }
}
