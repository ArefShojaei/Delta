<?php

namespace Delta\Components\Routing\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
abstract class Route
{
    public function __construct(
        public string $method = "",
        public string $path = "",
        public string $name = "",
        public array $middlewares = [],
    ) {}

    protected function toArray(): array
    {
        return [
            "method" => $this->method,
            "path" => $this->path,
            "name" => $this->name,
            "middlewares" => $this->middlewares
        ];
    }
}
