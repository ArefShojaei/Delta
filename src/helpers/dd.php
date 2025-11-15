<?php

/**
 * Dump and die data
 *
 * @param mixed $input variable or data will be shown
 */
if (!function_exists("dd")) {
    function dd(mixed $input): void
    {
        echo "<pre>";
        is_array($input) ? print_r($input) : var_dump($input);
        echo "</pre>";

        exit();
    }
}
