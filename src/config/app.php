<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | The name of your application. This value is used throughout the framework
    | when displaying the application name in notifications, logs, responses,
    | and other system-generated content.
    |
    */
    "name" => Delta\Components\Env\DotEnvironment::get(
        "APP_NAME",
        "Delta - PHP Framework",
    ),

    /*
    |--------------------------------------------------------------------------
    | Service Providers
    |--------------------------------------------------------------------------
    |
    | Register the application's service providers here. Service providers
    | are responsible for bootstrapping and configuring the core services
    | and features of the framework.
    |
    */
    "providers" => [
        Delta\Providers\DotEnvironmentServiceProvider::class,
        Delta\Providers\LoggingServiceProvider::class,
        Delta\Providers\StoreServiceProvider::class,
        Delta\Providers\RouterServiceProvider::class,
        Delta\Providers\HttpServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Middlewares
    |--------------------------------------------------------------------------
    |
    | These middlewares are executed for every incoming HTTP request.
    | They handle cross-cutting concerns such as CORS, security headers,
    | rate limiting, and response formatting.
    |
    */
    "middlewares" => [
        Delta\Middlewares\CORS::class,
        Delta\Middlewares\SecureHttpHeader::class,
        Delta\Middlewares\RateLimiter::class,
    ],
];
