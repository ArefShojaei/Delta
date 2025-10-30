<?php

namespace Delta\Components\Container;

use Closure;


final class Container implements ContainerContract {
    private array $instances = [];
    

    public function bind(string $abstract, string|Closure $concrete): void 
    {
        $this->instances[$abstract] = $concrete;    
    }

    public function resolve(string $abstract): null|object
    {
        if (!$this->has($abstract)) return null;

        $concrete = $this->instances[$abstract];

        return $concrete instanceof Closure ? $concrete($this) : new $concrete;
    }

    public function getInstances(): array
    {
        return $this->instances;
    }

    private function has(string $abstract): bool
    {
        return isset($this->instances[$abstract]);
    }
}