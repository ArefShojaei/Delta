<?php

namespace Delta\Components\Routing\Attributes;

use Attribute;
use Delta\Components\Http\Request;


#[Attribute(Attribute::TARGET_METHOD)]
class Patch extends Route
{
    public function __construct(public string $path = "")
    {
        parent::__construct(
            method: Request::EDITABLE,
            path: $path
        );
    }
}
