<?php

namespace Delta\Components\Routing;


interface RouteValidatorContract {
    public function isMethodExists(string $method): bool;
    public function isPathExists(string $method, string $path): bool;
}