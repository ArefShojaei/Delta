<?php

namespace Delta\Components\Reflection\Providers;

use Delta\Components\Reflection\ReflectionProvider;
use Delta\Components\Reflection\ReflectionService;
use ReflectionMethod;


final class MethodReflectionProvider extends ReflectionProvider
{
    private object $callback;


    public function __construct(ReflectionMethod $method, string $attribute)
    {
        $this->callback = fn ($params) => $method->invoke(new $method->class, ...$params);

        $this->attributes = ReflectionService::getReflectionAttributesFrom($method, $attribute);

        $this->descriptor = ReflectionService::getClassAttributeDescriptor($this->attributes);
    }


    public function __get(string $name)
    {
        return $this->{$name};
    }
}
