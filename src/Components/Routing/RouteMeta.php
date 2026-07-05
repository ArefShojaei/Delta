<?php

namespace Delta\Components\Routing;

use ReflectionClass;
use ReflectionMethod;

use Delta\Common\Interfaces\PropertyGetter as IPropertyGetter;

final class RouteMeta implements IPropertyGetter
{
    public function __construct(
        private ReflectionMethod $method,
        private ReflectionClass $reflection,
        private array $providers,
    ) {}

    public function __get(string $prop): mixed
    {
        return $this->{$prop};
    }
}
