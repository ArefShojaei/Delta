<?php

namespace Delta\Store;

use Delta\Store\Interfaces\LayerStore as ILayerStore;


final class LayerStore implements ILayerStore
{
    private $dependencies = [];


    public function addDependency(string $layer, object $instance): void
    {
        if (!isset($this->dependencies[$layer])) {
            $this->dependencies[$layer] = [];
        }

        if (!in_array($instance, $this->dependencies[$layer])) {
            $this->dependencies[$layer][] = $instance;
        }
    }

    public function getDependencies(?string $layer = null): ?array
    {
        if (is_null($layer)) return $this->dependencies;

        return $this->dependencies[$layer] ?? null;
    }
}
