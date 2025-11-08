<?php

namespace Delta\Components\Routing\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class MethodNotAllowed extends Get
{
    public const PATH = "/405";

    public function __construct()
    {
        parent::__construct(self::PATH);
    }
}
