<?php

namespace Delta\Store\Interfaces;


interface LayerStore
{
    public function addDependency(string $layer, object $instance): void;

    public function getDependencies(?string $layer = null): ?array;
}