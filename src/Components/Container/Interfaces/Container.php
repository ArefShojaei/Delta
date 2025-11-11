<?php

namespace Delta\Components\Container\Interfaces;

use Closure;


interface Container
{
    public function singleton(string $abstract, string|Closure $concrete): void;

    public function bind(string $abstract, string|Closure $concrete, bool $isSingleton = false): void;

    public function resolve(string $abstract): ?object;

    public function getBindings(): array;

    public function getInstances(): array;
}
