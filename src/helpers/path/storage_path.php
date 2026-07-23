<?php

if (!function_exists("storage_path")) {
    function storage_path(?string $dir = null): string
    {
        $path = dirname(__DIR__, 2) . "/storage";

        return is_null($dir) ? $path : $path . "/" . $dir;
    }
}
