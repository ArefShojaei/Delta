<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\Attributes\Module;
use ReflectionClass;


trait CanGetAttribute
{
    protected function getAttribute(): Module
    {
        $moduleReflection = new ReflectionClass($this->module);

        $attributes = $moduleReflection->getAttributes(Module::class);

        return current($attributes)->newInstance();
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
