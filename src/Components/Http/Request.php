<?php

namespace Delta\Components\Http;

use Delta\Components\Http\{
    Interfaces\Request as IRequest,
    Enums\HttpRequestHeader,
};


final class Request implements IRequest
{
    public const READABLE = "GET";

    public const CREATABLE = "POST";

    public const UPDATEABLE = "PUT";

    public const EDITABLE = "PATCH";

    public const DELETABLE = "DELETE";


    public function __construct(private array $headers) {}

    public function header(string|HttpRequestHeader $key): ?string
    {
        if ($key instanceof HttpRequestHeader) return $this->headers[$key->value] ?? null;

        return $this->headers[$key] ?? null;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function method(): string
    {
        return $this->header(HttpRequestHeader::METHOD);
    }

    public function uri(): string
    {
        return $this->header(HttpRequestHeader::URI);
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

    public function query(?string $key = null): null|string|array
    {
        if (is_null($key)) return $_GET;

        return $_GET[$key] ?? null;
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
        return $this->header(HttpRequestHeader::HOST);
    }

    public function body(?string $key = null): null|string|array
    {
        $data = json_decode(file_get_contents("php://input"), true) ?? [];

        if (is_null($key)) return $data;

        return $data[$key] ?? null;
    }

    public function params(?string $key = null): null|string|array
    {
        global $_PARAMS;

        if (is_null($key)) return $_PARAMS ?? [];

        return $_PARAMS[$key] ?? null;
    }
}
