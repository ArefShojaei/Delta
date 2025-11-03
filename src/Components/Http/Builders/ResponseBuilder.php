<?php

namespace Delta\Components\Http\Builders;

use Delta\Components\Session\Session;
use Delta\Components\Cookie\Interfaces\Cookie;
use Delta\Components\Http\Builders\ResponseBuilder as IResponseBuilder;
use Delta\Components\Http\Response;


final class ResponseBuilder implements IResponseBuilder
{
    private Response $response;


    public function __construct()
    {
        $this->response = new Response;        
    }

    public function setHeader(string $key, string $value): self
    {
        header("{$key}: {$value}");
        
        return $this;
    }

    public function setHeaders(array $headers): self
    {
        foreach ($headers as $key => $value) {
            header("{$key}: {$value}");
        }
        
        return $this;
    }

    public function setStatus(Response|int $code): self
    {
        http_response_code($code);

        return $this;
    }

    public function setCookie(string $key, string $value): self
    {
        Cookie::set($key, $value);

        return $this;
    }

    public function setSession(string $key, string $value): self
    {
        Session::set($key, $value);

        return $this;
    }

    public function setBody(array $body): self
    {
        $this->response->setBody($body);

        return $this;
    }

    public function build(): Response
    {
        return $this->response;
    }
}