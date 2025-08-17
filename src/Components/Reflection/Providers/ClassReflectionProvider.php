<?php

namespace Delta\Components\Reflection\Providers;

use Delta\Components\Reflection\ReflectionProvider;
use Delta\Components\Reflection\ReflectionService;
use ReflectionClass;


final class ClassReflectionProvider extends ReflectionProvider
{
    public function __construct(ReflectionClass|string $class, string $attribute)
    {
        $this->reflection = ReflectionService::registerClass($class);

        $this->attributes = ReflectionService::getReflectionAttributesFrom($this->reflection, $attribute);

        $this->methods = ReflectionService::getClassMethods($this->reflection);

        $this->descriptor = ReflectionService::getClassAttributeDescriptor($this->attributes);
    }
}
