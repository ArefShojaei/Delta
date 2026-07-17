<?php

namespace Delta\Components\Store;

use Delta\Components\Store\Interfaces\Store as IStore;
use Delta\Components\Store\Exceptions\InvalidStoreProviderException;

final class Store implements IStore
{
    private $dependencies = [];

    /**
     * @param string $abstract (e.g., "user.provider", "product.export")
     */
    public function addDependency(string $abstract, object $concrete): void
    {
        if (!str_contains($abstract, ".")) throw new InvalidStoreProviderException();

        [$component, $layer] = explode(".", $abstract);

        if (!isset($this->dependencies[$component][$layer])) {
            $this->dependencies[$component][$layer] = [];
        }

        if (!in_array($concrete, $this->dependencies[$component][$layer])) {
            $this->dependencies[$component][$layer][] = $concrete;
        }
    }

    public function getDependencies(?string $abstract = null): ?array
    {
        if (is_null($abstract)) return $this->dependencies;

        if (!str_contains($abstract, ".")) throw new InvalidStoreProviderException();

        [$component, $layer] = explode(".", $abstract);

        return $this->dependencies[$component][$layer] ?? null;
    }
}
