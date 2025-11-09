<?php

return [
    /**
     * Application name
     */
    "name" => \Delta\Components\Env\DotEnvEnvironment::get("name", "Delta - PHP Framework"),

    /**
     * Application service providers as dependencies before bootstrapping the server
     */
    "providers" => [
        Delta\Services\RouterServiceProvider::class,
        Delta\Services\HttpServiceProvider::class,
    ],

    /**
     * Global Middlewares
     */
    "middlewares" => [
        Delta\Middlewares\CORS::class,
        Delta\Middlewares\SecureHttpHeader::class,
    ]
];
