<?php

namespace Delta\Components\Routing\Interfaces;


interface RouterValidator
{
    public function isMethodExists(string $method): bool;
    
    public function isPathExists(string $method, string $path): bool;
}
