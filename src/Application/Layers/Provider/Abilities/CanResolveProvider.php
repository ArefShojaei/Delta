<?php

namespace Delta\Application\Layers\Provider\Abilities;

use Delta\Components\Layer\{
    Attributes\Injectable,
    Enums\LayerType
};
use ReflectionClass;


trait CanResolveProvider
{
    private function getProviderName(ReflectionClass $reflection): string
    {
        $namespaceParts = explode("\\", $reflection->getNamespaceName());

        $component = end($namespaceParts);

        return $component;
    }

    private function getProviderLayerName(string $component): string
    {
        return LayerType::PROVIDER->value . "." . lcfirst($component);
    }
}
