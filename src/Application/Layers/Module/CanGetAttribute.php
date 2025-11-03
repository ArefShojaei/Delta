<?php

namespace Delta\Application\Layers\Module;

use Delta\Application\Attributes\Module;
use ReflectionClass;


trait CanGetAttribute
{
    private function getAttribute(): Module
    {
        $moduleReflection = new ReflectionClass($this->module);

        $attributes = $moduleReflection->getAttributes(Module::class);

        return current($attributes)->newInstance();
    }

    private function getAttributeControllers(): array
    {
        $meta = $this->getAttribute()->meta;

        return $meta["controllers"];
    }

    private function getAttributeProviders(): array
    {
        $meta = $this->getAttribute()->meta;

        return $meta["providers"];
    }

    private function getAttributeImports(): array
    {
        $meta = $this->getAttribute()->meta;

        return $meta["imports"];
    }

    private function getAttributeExports(): array
    {
        $meta = $this->getAttribute()->meta;

        return $meta["exports"];
    }
}
