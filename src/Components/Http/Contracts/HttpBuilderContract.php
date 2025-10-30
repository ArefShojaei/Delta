<?php

namespace Delta\Components\Http\Contracts;

use Delta\Components\Http\Http;
use Delta\Components\Routing\Router;


interface HttpBuilderContract
{
    public function setRequest(array $headers): self;
    public function setResponse(): self;
    public function setRouter(Router $router): self;
    public function build(): Http;
}
