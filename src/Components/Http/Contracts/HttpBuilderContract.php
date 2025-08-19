<?php

namespace Delta\Components\Http\Contracts;

use Delta\Components\Http\Http;
use Delta\Components\Routing\Router;


interface HttpBuilderContract
{
    public function setRequest(): self;
    public function setResponse(): self;
    public function setRouter(Router $router): self;
    public function build(): Http;
}
