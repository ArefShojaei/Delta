<?php

namespace Delta\Components\Routing\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class Middleware extends Route {
    public function __construct(public array $middlewares)
    {
        parent::__construct(middlewares: $this->middlewares);
    }
}
