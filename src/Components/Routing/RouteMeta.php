<?php

namespace Delta\Components\Routing;

use Delta\Common\Interfaces\PropertyGetter as IPropertyGetter;
use ReflectionClass;
use ReflectionMethod;


final class RouteMeta implements IPropertyGetter
{
    public function __construct(
        private ReflectionMethod $method,
        private ReflectionClass $reflection,
        private array $providers,
    ) {}

    public function __get($prop): mixed
    {
        return $this->{$prop};
    }
}
