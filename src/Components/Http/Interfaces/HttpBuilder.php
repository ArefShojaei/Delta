<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\{
    Http\Http,
    Routing\Router
};


interface HttpBuilder
{
    public function setRequest(array $headers): self;

    public function setResponse(): self;

    public function setRouter(Router $router): self;

    public function build(): Http;
}
