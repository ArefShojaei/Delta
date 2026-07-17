<?php

namespace Delta\Components\Layer\Support\Export\Abilities;

use ReflectionClass;

use Delta\Components\Layer\Enums\LayerType;

trait CanResolveExportProvider
{
    private function getExportProviderName(ReflectionClass $reflection): string
    {
        $namespaceParts = explode("\\", $reflection->getNamespaceName());

        $component = end($namespaceParts);

        return $component;
    }

    private function getExportProviderLayerName(string $component): string
    {
        return lcfirst($component) . "." . LayerType::EXPORT->value . "s";
    }
}
