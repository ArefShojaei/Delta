<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Http\HttpStatus;


interface Response
{
    public function body(array $data): void;

    public function header(string $key, string $value): void;

    public function cookie(string $key, string $value): void;

    public function session(string $key, string $value): void;

    public function status(int|HttpStatus $code): void;
    
    public function json(array $data): void;
    
    public function html(string $content): void;

    public function send(): void;
}
