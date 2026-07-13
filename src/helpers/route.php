<?php

use Delta\Components\Routing\RouteAlias;

/**
 * Get Route by name
 */
if (!function_exists("route")) {
    function route(string $name): ?string
    {
        return RouteAlias::getName($name);
    }
}
