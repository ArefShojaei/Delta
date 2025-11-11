<?php

return [
    /**
     * Application name
     */
    "name" => \Delta\Components\Env\DotEnvEnvironment::get("APP_NAME", "Delta - PHP Framework"),

    /**
     * Application service providers as dependencies before bootstrapping the server
     */
    "providers" => [
        Delta\Providers\RouterServiceProvider::class,
        Delta\Providers\HttpServiceProvider::class,
    ],

    /**
     * Global Middlewares
     */
    "middlewares" => [
        Delta\Middlewares\CORS::class,
        Delta\Middlewares\SecureHttpHeader::class,
    ]
];
