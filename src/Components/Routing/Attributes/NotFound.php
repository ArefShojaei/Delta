<?php

namespace Delta\Components\Routing\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class NotFound extends Get
{
    public const PATH = "/404";

    public function __construct()
    {
        parent::__construct(self::PATH);
    }
}
