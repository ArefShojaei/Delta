<?php

namespace Delta\Components\Http;

use Delta\Components\Http\{
    Interfaces\Request as IRequest,
    Enums\HttpRequestHeader
};


final class Request implements IRequest
{
    public const READABLE = "GET";

    public const CREATABLE  = "POST";

    public const UPDATEABLE = "PUT";

    public const EDITABLE = "PATCH";

    public const DELETABLE  = "DELETE";


    public function __construct(private array $headers)
    {
    }

    public function header(string|HttpRequestHeader $name): ?string
    {
        if ($name instanceof HttpRequestHeader) $this->headers[$name->value] ?? null;

        return $this->headers[$name] ?? null;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function method(): string
    {
        return $this->header(HttpRequestHeader::METHOD);
    }

    public function path(): string
    {
        return $this->header(HttpRequestHeader::PATH);
    }

    public function route(): string
    {
        return $this->header(HttpRequestHeader::ROUTE);
    }

    public function ip(): string
    {
        return $this->header(HttpRequestHeader::IP);
    }

    public function protocol(): string
    {
        return $this->header(HttpRequestHeader::PROTOCOL);
    }

    public function domain(): string
    {
        return $this->header(HttpRequestHeader::DOMAIN);
    }

    public function query(): array
    {
        $params = [];

        if (!$this->header(HttpRequestHeader::QUERY)) return $params;

        $inputs = explode("&", $this->header(HttpRequestHeader::QUERY));

        foreach ($inputs as $input) {
            [$key, $value] = explode("=", $input);

            $params[$key] = $value;
        }

        return $params;
    }

    public function agent(): string
    {
        return $this->header(HttpRequestHeader::AGENT);
    }

    public function time(): int
    {
        return (int) $this->header(HttpRequestHeader::TIME);
    }

    public function host(): string
    {
        return (int) $this->header(HttpRequestHeader::HOST);
    }
}
