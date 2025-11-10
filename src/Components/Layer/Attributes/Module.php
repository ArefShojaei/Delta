<?php

namespace Delta\Application\Attributes;

use Attribute;


#[Attribute(Attribute::TARGET_CLASS)]
class Module
{
    /**
     * @param array $options Controllers - Providers - Imports - Exports
     */
    public function __construct(public array $options) {}
}
