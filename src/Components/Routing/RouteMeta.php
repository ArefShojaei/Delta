<?php

namespace Delta\Components\Routing;

use ReflectionClass;
use ReflectionMethod;


final class RouteMeta
{
    public function __construct(
        private ReflectionMethod $method,
        private ReflectionClass $reflection,
    ) {}

    public function __get($name)
    {
        return $this->{$name};
    }
}