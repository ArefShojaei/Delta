<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Http\HttpStatus;


interface JsonResponse
{
    public function json(array $data): void;
}

interface HtmlResponse
{
    public function html(string $content): void;
}

interface OutputResponse extends JsonResponse, HtmlResponse {}


interface Response extends OutputResponse
{
    public function body(array $data): void;

    public function header(string $key, string $value): void;

    public function cookie(string $key, string $value): void;

    public function session(string $key, string $value): void;

    public function status(int|HttpStatus $code): void;

    public function send(): void;
}
