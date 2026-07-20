<?php

namespace Delta\Components\Store\Interfaces;

use Delta\Components\Store\Enums\StoreType;

interface Store
{
    public function set(
        string $abstract,
        StoreType $key,
        object|string $concrete,
    ): void;

    public function setRecursive(
        string $abstract,
        StoreType $key,
        array $concretes,
    ): void;

    public function get(string $abstract, StoreType $key): array;

    public function all(?string $abstract = null): array;

    public function has(string $abstract, StoreType $key): bool;

    public function clean(): void;
}
