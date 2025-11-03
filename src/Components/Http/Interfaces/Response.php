<?php

namespace Delta\Components\Http\Interfaces;


interface Response
{
    public function body(array $body): void;

    public function header(string $key, string $value): void;

    public function cookie(string $key, string $value): void;

    public function session(string $key, string $value): void;

    public function status($code): void;

    public function send(): void;
}
