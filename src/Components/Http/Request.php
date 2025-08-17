<?php

namespace Delta\Components\Http;


final class Request
{
    public const READABLE = "GET";

    public const CREATABLE  = "POST";

    public const UPDATEABLE = "PUT";

    public const EDITABLE = "PATCH";

    public const DELETABLE  = "DELETE";


    public function __construct(private array $headers)
    {
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function method(): string
    {
        return $this->headers["REQUEST_METHOD"];
    }

    public function route(): string
    {
        return $this->headers["REQUEST_URI"];
    }
}
