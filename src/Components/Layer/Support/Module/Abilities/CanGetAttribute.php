<?php

namespace Delta\Components\Layer\Support\Module\Abilities;

use ReflectionClass;

use Delta\Components\Layer\Attributes\Module;
use Delta\Components\Layer\Exceptions\{
    ReflectionAttributeException,
    ReflectionModuleException,
    ReflectionTypeException,
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

        if (!is_object($attribute)) throw new ReflectionTypeException();

        return $attribute->newInstance();
    }

    private function getAttributeControllers(): array
    {
        return $this->getAttribute()->controllers;
    }

    private function getAttributeProviders(): array
    {
        return $this->getAttribute()->providers;
    }

    private function getAttributeImports(): array
    {
        return $this->getAttribute()->imports;
    }

    private function getAttributeExports(): array
    {
        return $this->getAttribute()->exports;
    }
}
