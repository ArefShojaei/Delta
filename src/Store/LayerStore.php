<?php

namespace Delta\Store;

use Delta\Store\Interfaces\LayerStore as ILayerStore;


final class LayerStore implements ILayerStore
{
    private $dependencies = [];


    public function addDependency(string $layer, object $instance): void
    {
        $this->dependencies[$layer][] = $instance;
    }

    public function getDependencies(?string $layer = null): ?array
    {
        if (is_null($layer)) return $this->dependencies;

        return $this->dependencies[$layer] ?? null;
    }
}
