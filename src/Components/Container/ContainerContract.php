<?php

namespace Delta\Components\Container;

use Closure;


interface ContainerContract {
    public function bind(string $abstract, string|Closure $concrete): void;
    public function resolve(string $abstract): ?object;
    public function getInstances(): array;
}