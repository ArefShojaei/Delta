<?php

namespace Delta\Components\Http;


interface RequestContract
{
    public function headers(): array;
    public function method(): string;
    public function url(): string;
    public function route(): string;
    public function ip(): string;
    public function protocol(): string;
    public function domain(): string;
    public function host(): string;
    public function port(): string;
    public function query(): array;
    public function agnet(): string;
    public function time(): int;
}
