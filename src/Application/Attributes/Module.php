<?php

namespace Delta\Application\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Module
{
    public function __construct(public array $meta) {}
}
