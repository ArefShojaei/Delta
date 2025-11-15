<?php

namespace Delta\Application\Layers\Controller\Abilities;

use Delta\Components\Layer\Attributes\Controller;
use ReflectionClass;


trait CanResolveControllerAttribute
{
    private function getControllerAttribute(ReflectionClass $reflection):object
    {
        $attributes = $reflection->getAttributes(Controller::class);

        return current($attributes)->newInstance();
    }

    private function getPrefix(ReflectionClass $reflection): ?string
    {
        $attribute = $this->getControllerAttribute($reflection);

        return $attribute->prefix;
    }

    private function getRoutePrefixName(ReflectionClass $reflection): string
    {
        $attribute = $this->getControllerAttribute($reflection);

        return $attribute->name;
    }
}
