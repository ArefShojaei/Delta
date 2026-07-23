<?php

if (!function_exists("config_path")) {
    function config_path(): string
    {
        return dirname(__DIR__, 2) . "/config";
    }
}
