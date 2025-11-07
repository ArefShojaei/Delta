<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Http\Enums\HttpRequestHeader;


interface RequestHeader
{
    public function header(string|HttpRequestHeader $key): ?string;

    public function headers(): array;

    public function method(): string;

    public function ip(): string;

    public function agent(): string;

    public function time(): int;

    public function body(?string $key = null): null|string|array;
}

interface RequestUrl
{
    public function path(): string;

    public function route(): string;

    public function protocol(): string;

    public function domain(): string;

    public function query(?string $key = null): null|string|array;

    public function host(): string;
}


interface Request extends RequestHeader, RequestUrl {}
