<?php

namespace Delta\Components\Env\interfaces;

interface DotEnvironment
{
    public function load(string $path): void;

    public static function get(string $key, ?string $default = null): ?string;
}
