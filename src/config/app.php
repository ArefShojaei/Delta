<?php

return [
    /**
     * Application service providers as dependencies before bootstrapping the server
     */
    "providers" => [
        Delta\Services\RouterServiceProvider::class,
        Delta\Services\HttpServiceProvider::class,
    ],
];
