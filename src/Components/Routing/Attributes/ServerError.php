<?php

namespace Delta\Components\Routing\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class ServerError extends Get
{
    public const PATH = "/500";

    public function __construct()
    {
        parent::__construct(self::PATH);
    }
}
