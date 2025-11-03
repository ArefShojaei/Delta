<?php

namespace Delta\Components\Http\Builders;

use Delta\Components\Http\{
    Builders\ResponseBuilder as IResponseBuilder,
    HttpStatus,
    Response
};


final class ResponseBuilder implements IResponseBuilder
{
    private Response $response;


    public function __construct()
    {
        $this->response = new Response;        
    }

    public function setHeader(string $key, string $value): self
    {
        $this->response->header($key, $value);
        
        return $this;
    }

    public function setHeaders(array $headers): self
    {
        foreach ($headers as $key => $value) {
            $this->response->header($key, $value);
        }
        
        return $this;
    }

    public function setStatus(Response|HttpStatus|int $code): self
    {
        $this->response->status($code);

        return $this;
    }

    public function setCookie(string $key, string $value): self
    {
        $this->response->cookie($key, $value);

        return $this;
    }

    public function setSession(string $key, string $value): self
    {
        $this->response->session($key, $value);

        return $this;
    }

    public function setBody(array $body): self
    {
        $this->response->body($body);

        return $this;
    }

    public function build(): Response
    {
        return $this->response;
    }
}