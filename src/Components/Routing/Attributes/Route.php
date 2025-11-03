<?php

namespace Delta\Components\Routing\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
abstract class Route
{
    public function __construct(public string $method, public string $path) {}

    protected function toArray(): array
    {
        return [
            "method" => $this->method,
            "path" => $this->path,
        ];
    }
}
