<?php

/**
 * Get Route by name
 */
if (!function_exists("route")) {
    function route(string $name): ?string
    {
        global $_ROUTE_NAMES;

        return $_ROUTE_NAMES[$name] ?? null;
    }
}
