<?php

namespace Delta\Components\Http;

use Delta\Components\Http\Contracts\RequestContract;


final class Request implements RequestContract
{
    public const READABLE = "GET";

    public const CREATABLE  = "POST";

    public const UPDATEABLE = "PUT";

    public const EDITABLE = "PATCH";

    public const DELETABLE  = "DELETE";


    public function __construct(private array $headers)
    {
    }

    private function getHeader(string $name): string
    {
        return $this->headers[$name];
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function method(): string
    {
        return $this->getHeader("REQUEST_METHOD");
    }

    public function url(): string
    {
        return $this->getHeader("REQUEST_URI");
    }

    public function route(): string
    {
        return $this->getHeader("PHP_SELF");
    }

    public function ip(): string
    {
        return $this->getHeader("REMOTE_ADDR");
    }

    public function protocol(): string
    {
        return $this->getHeader("SERVER_PROTOCOL");
    }

    public function domain(): string
    {
        return $this->getHeader("SERVER_NAME");
    }

    public function host(): string
    {
        return $this->getHeader("HTTP_HOST");
    }

    public function port(): string
    {
        return $this->getHeader("SERVER_NAME");
    }

    public function query(): array
    {
        $queries = [];

        $inputs = explode("&", $this->getHeader("QUERY_STRING"));

        foreach ($inputs as $input) {
            [$key, $value] = explode("=", $input);

            $queries[$key] = $value;
        }

        return $queries;
    }

    public function agnet(): string
    {
        return $this->getHeader("HTTP_USER_AGENT");
    }

    public function time(): int
    {
        return (int) $this->getHeader("REQUEST_TIME");
    }
}
