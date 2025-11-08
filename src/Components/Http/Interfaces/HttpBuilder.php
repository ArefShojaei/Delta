<?php

namespace Delta\Components\Http\Interfaces;

use Delta\Components\Routing\Router;
use Delta\Components\Http\{Http, Request, Response};


interface HttpBuilder
{
    public function setRequest(Request $request): self;

    public function setResponse(Response $response): self;

    public function setRouter(Router $router): self;

    public function build(): Http;
}
