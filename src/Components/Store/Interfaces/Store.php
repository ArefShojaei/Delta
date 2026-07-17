<?php

namespace Delta\Components\Store\Interfaces;

interface Store
{
    public function addDependency(string $abstract, object $concrete): void;

    public function getDependencies(?string $abstract = null): ?array;
}
