<?php

namespace Delta\Components\Reflection;

use ReflectionClass;
use ReflectionMethod;


interface ReflectionServiceContract
{
    public static function registerClass(string $class): ReflectionClass;
    public static function getReflectionAttributesFrom(ReflectionClass|ReflectionMethod $reflection, string $attribute): array;
    public static function getClassMethods(ReflectionClass $reflection): array;
    public static function getClassAttributeDescriptor(array $attributes): object;
}
