<?php

namespace Delta\Components\Routing;

use Closure;
use Delta\Common\Interfaces\PropertyGetter as IPropertyGetter;


final class Route implements IPropertyGetter
{
    public function __construct(
        private string $method,
        private string $path,
        private RouteMeta|Closure $meta,
    ) {}

    public function __get($prop): mixed
    {
        return $this->{$prop};
    }
}
