<?php

namespace Delta\Components\Routing;

use Delta\Components\Routing\Contracts\RouterValidatorContract;


final class RouterValidator implements RouterValidatorContract
{
    public function __construct(private array $routes)
    {
    }

    public function isMethodExists(string $method): bool
    {
        return array_key_exists($method, $this->routes);
    }

    public function isPathExists(string $method, string $path): bool
    {
        return array_key_exists($path, $this->routes[$method]);
    }
}
