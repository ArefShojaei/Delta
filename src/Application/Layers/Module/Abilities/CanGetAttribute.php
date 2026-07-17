<?php

namespace Delta\Application\Layers\Module\Abilities;

use ReflectionClass;

use Delta\Components\Layer\Attributes\Module;
use Delta\Application\Exceptions\{
    ReflectionAttributeException,
    ReflectionModuleException,
    ReflectionTypeException
};

trait CanGetAttribute
{
    protected function getAttribute(): Module
    {
        $moduleReflection = new ReflectionClass($this->module);

        if (!$moduleReflection) throw new ReflectionModuleException();

        $attributes = $moduleReflection->getAttributes(Module::class);

        if (empty($attributes)) throw new ReflectionAttributeException();

        $attribute = current($attributes);

        if (!is_object($attribute)) throw new ReflectionTypeException;

        return $attribute->newInstance();
    }

    private function getAttributeControllers(): array
    {
        $options = $this->getAttribute()->options;

        return $options["controllers"] ?? [];
    }

    private function getAttributeProviders(): array
    {
        $options = $this->getAttribute()->options;

        return $options["providers"] ?? [];
    }

    private function getAttributeImports(): array
    {
        $options = $this->getAttribute()->options;

        return $options["imports"] ?? [];
    }

    private function getAttributeExports(): array
    {
        $options = $this->getAttribute()->options;

        return $options["exports"] ?? [];
    }
}
