<?php

namespace Delta\Components\Layer\Support\Provider\Abilities;

use ReflectionClass;

use Delta\Components\Layer\Enums\LayerType;

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
        return lcfirst($component) . "." . LayerType::PROVIDER->value . "s";
    }
}
