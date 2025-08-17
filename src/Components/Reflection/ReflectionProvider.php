<?php

namespace Delta\Components\Reflection;

use ReflectionClass;


abstract class ReflectionProvider implements ReflectionProviderContract
{
    protected ReflectionClass $reflection;

    protected array $attributes;

    protected array $methods;

    protected object $descriptor;


    public function __get(string $name)
    {
        return $this->{$name};
    }
}
