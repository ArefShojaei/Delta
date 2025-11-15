<?php

namespace Delta\Components\Layer\Attributes;

use Attribute;


#[Attribute(Attribute::TARGET_CLASS)]
class Controller
{
    /**
     * @param string $prefix Route prefix
     * @param string $name Route name
     */
    public function __construct(public string $prefix = "/", public string $name = "") {}
}
