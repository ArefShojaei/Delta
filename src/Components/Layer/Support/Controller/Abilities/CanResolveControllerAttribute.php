<?php

namespace Delta\Components\Layer\Support\Controller\Abilities;

use ReflectionClass;

use Delta\Components\Layer\Exceptions\ReflectionAttributeException;
use Delta\Components\Layer\{Attributes\Controller, Enums\LayerType};

trait CanResolveControllerAttribute
{
    private function getControllerAttribute(ReflectionClass $reflection): object
    {
        $attributes = $reflection->getAttributes(Controller::class);

        $attribute = current($attributes);

        if (!is_object($attribute)) throw new ReflectionAttributeException;

        return $attribute->newInstance();
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

    private function getControllerClassName(ReflectionClass $reflection): string
    {
        $className = $reflection->getName();

        $controllerLayerName = ucfirst(LayerType::CONTROLLER->value);

        [$name, $_] = explode($controllerLayerName, $className);

        return $name;
    }
}
