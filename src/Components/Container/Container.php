<?php

namespace Delta\Components\Container;

use Delta\Components\Container\Interfaces\Container as IContainer;
use Closure;


final class Container implements IContainer
{
    private array $bindings = [];

    private array $instances = [];


    public function singleton(string $abstract, string|Closure $concrete): void
    {
        $this->bind($abstract, $concrete, true);
    }

    public function bind(string $abstract, string|Closure $concrete, bool $isSingleton = false): void
    {
        $this->bindings[$abstract] = [$isSingleton, $concrete];
    }

    public function resolve(string $abstract): ?object
    {
        if (!$this->has($abstract)) return null;

        [$isSingleton, $concrete] = $this->bindings[$abstract];

        # Is Clouser
        if ($concrete instanceof Closure) return $concrete($this);

        # Is Singleton
        if ($isSingleton) return $concrete::getInstance();

        # Is Instnace
        if (isset($this->instances[$abstract])) return $this->instances[$abstract];

        $this->instances[$abstract] = new $concrete;

        return $this->instances[$abstract];
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }

    public function getInstances(): array
    {
        return $this->instances;
    }

    private function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }
}
