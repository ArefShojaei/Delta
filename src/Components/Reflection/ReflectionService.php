<?php

namespace Delta\Components\Reflection;

use Delta\Components\Reflection\Contracts\ReflectionServiceContract;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;


final class ReflectionService implements ReflectionServiceContract
{
    public static function registerClass(string $class): ReflectionClass
    {
        return new ReflectionClass($class);
    }

    public static function getReflectionAttributesFrom(ReflectionClass|ReflectionMethod $reflection, string $attribute): array
    {
        return $reflection->getAttributes($attribute, ReflectionAttribute::IS_INSTANCEOF);
    }

    public static function getClassMethods(ReflectionClass $reflection): array
    {
        return $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
    }

    public static function getClassAttributeDescriptor(array $attributes): object
    {
        return current($attributes)->newInstance();
    }
}
