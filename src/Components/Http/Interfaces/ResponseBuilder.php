<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Http\{HttpStatus, Response};

interface ResponseBuilder
{
    public function setHeader(string $key, string $value): self;

    public function setHeaders(array $headers): self;

    public function setStatus(HttpStatus|Response|int $code): self;

    public function setCookie(
        string $key,
        string $value,
        int $expires = 0,
        string $path = "",
        string $domain = "",
        bool $secure = false,
        bool $httponly = false,
    ): self;

    public function setSession(string $key, string $value): self;

    public function setBody(array $body): self;

    public function build(): Response;
}
