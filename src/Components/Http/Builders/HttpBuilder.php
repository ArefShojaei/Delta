<?php

namespace Delta\Components\Http;

use Delta\Components\Http\Interfaces\HttpBuilder as IHttpBuilder;
use Delta\Components\{
    Http\Response,
    Routing\Router
};


final class HttpBuilder implements IHttpBuilder
{
    private Request $request;

    private Response $response;

    private Router $router;


    public function setRequest(array $headers): self {
        $this->request = HttpFactory::createRequest($headers);

        return $this;
    }
    
    public function setResponse(): self {
        $this->response = HttpFactory::createResponse();
        
        return $this;
    }

    public function setRouter(Router $router): self {
        $this->router = $router;

        return $this;
    }

    public function build(): Http {
        $meta = ["router" => $this->router];

        return HttpFactory::createHttp(
            $this->request, 
            $this->response, 
            $meta
        );
    }
}