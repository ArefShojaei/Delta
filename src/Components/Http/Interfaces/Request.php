<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Http\Enums\HttpRequestHeader;


interface Request
{
    public function header(string|HttpRequestHeader $name): ?string;

    public function headers(): array;

    public function method(): string;

    public function path(): string;

    public function route(): string;

    public function ip(): string;

    public function protocol(): string;

    public function domain(): string;

    public function query(): array;

    public function agent(): string;

    public function time(): int;

    public function host(): string;
}
