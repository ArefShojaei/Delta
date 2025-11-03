<?php

namespace Delta\Components\Routing;


final class Route
{
    public function __construct(
        private string $method,
        private string $path,
        private object $callback,
    ) {}

    public function __get($name)
    {
        return $this->{$name};
    }
}
