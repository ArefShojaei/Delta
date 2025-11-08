<?php

namespace Delta\Components\Env\interfaces;


interface DotEnvEnvironment
{
    public function load(string $path): void;

    public static function get(string $key, ?string $defaultValue = null): ?string;
}
