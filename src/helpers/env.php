<?php

use Delta\Components\Env\DotEnvironment;

if (!function_exists("env")) {
    function env(string $key, ?string $default = null): ?string
    {
        return DotEnvironment::get($key, $default);
    }
}
