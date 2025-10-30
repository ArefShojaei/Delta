<?php

namespace Delta\Components\Routing\Contracts;


interface RouterValidatorContract {
    public function isMethodExists(string $method): bool;
    public function isPathExists(string $method, string $path): bool;
}