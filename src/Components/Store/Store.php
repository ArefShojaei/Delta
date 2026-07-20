<?php

namespace Delta\Components\Store;

use Delta\Components\Store\Enums\StoreType;
use Delta\Components\Store\Interfaces\Store as IStore;

final class Store implements IStore
{
    private array $dependencies = [];

    public function set(
        string $abstract,
        StoreType $key,
        object|string $concrete,
    ): void {
        if (!$this->has($abstract, $key)) {
            $this->dependencies[$abstract][$key->value] = [];
        }

        if (!in_array($concrete, $this->dependencies[$abstract][$key->value])) {
            $this->dependencies[$abstract][$key->value][] = $concrete;
        }
    }

    public function setRecursive(
        string $abstract,
        StoreType $key,
        array $concretes,
    ): void {
        if (empty($concretes)) return;

        foreach ($concretes as $concrete) {
            $this->set($abstract, $key, $concrete);
        }
    }

    public function get(string $abstract, StoreType $key): array
    {
        return $this->dependencies[$abstract][$key->value] ?? [];
    }

    public function all(?string $abstract = null): array
    {
        return is_null($abstract)
            ? $this->dependencies
            : $this->dependencies[$abstract];
    }

    public function has(string $abstract, StoreType $key): bool
    {
        return array_key_exists($abstract, $this->dependencies) &&
            array_key_exists($key->value, $this->dependencies[$abstract]);
    }

    public function clean(): void
    {
        unset($this->dependencies);
    }
}
