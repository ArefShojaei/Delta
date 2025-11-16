<?php

namespace Delta\Store\Interfaces;


interface LayerStore
{
    public function addDependency(string $abstract, object $concrete): void;

    public function getDependencies(?string $abstract = null): ?array;
}
