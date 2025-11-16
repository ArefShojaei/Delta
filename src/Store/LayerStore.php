<?php

namespace Delta\Store;

use Delta\Store\Interfaces\LayerStore as ILayerStore;


final class LayerStore implements ILayerStore
{
    private $dependencies = [];


    /**
     * @param string $abstract (e.g., "provider.user", "provider.swagger")
     */
    public function addDependency(string $abstract, object $concrete): void
    {
        [$layer, $component] = explode(".", $abstract);


        if (!isset($this->dependencies[$layer][$component])) {
            $this->dependencies[$layer][$component] = [];
        }

        if (!in_array($concrete, $this->dependencies[$layer][$component])) {
            $this->dependencies[$layer][$component][] = $concrete;
        }
    }

    public function getDependencies(?string $abstract = null): ?array
    {
        if (is_null($abstract)) return $this->dependencies;


        [$layer, $component] = explode(".", $abstract);

        return $this->dependencies[$layer][$component] ?? null;
    }
}
