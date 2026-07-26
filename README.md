<p align="center">
  <a href="https://github.com/ArefShojaei/Delta" target="_blank">
    <img width="200" alt="Delta" src="https://github.com/user-attachments/assets/1216b0b2-72fd-4e07-8227-b2b137662671" />
  </a>
</p>

<p align="center">
  A lightweight PHP framework for building clean, modular REST APIs.
</p>

<p align="center">
  <a href="https://php.net"><img alt="PHP" src="https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white"></a>
  <a href="https://github.com/ArefShojaei/Delta/blob/main/LICENSE"><img alt="License" src="https://img.shields.io/badge/license-MIT-green"></a>
  <a href="https://packagist.org/packages/arefshojaei/delta"><img alt="Package" src="https://img.shields.io/badge/package-arefshojaei%2Fdelta-blue"></a>
</p>

<img width="100%" alt="Delta cover" src="https://github.com/user-attachments/assets/b816af49-828e-4e52-adfe-06f72747178b" />

## About Delta

Delta is a PHP framework focused on REST API development. It provides a module-oriented application structure, attribute-based routing, a simple dependency container, request and response objects, middleware support, environment loading, file cache, and logging.

Delta is designed to keep application code readable:

- Group features into modules.
- Register controllers and providers with PHP attributes.
- Define routes directly on controller methods.
- Return JSON responses through a small response API.
- Keep cross-cutting behavior in middleware.

## Features

- Attribute-based modules, controllers, and routes
- HTTP route methods: `GET`, `POST`, `PUT`, `PATCH`, `DELETE`
- Route parameters such as `/users/{id}`
- Named routes through route aliases
- Global and route-level middleware
- Lightweight service container with singleton support
- Request and response abstractions
- Dotenv-style environment loader
- File-based cache
- File-based logger
- Session and cookie helpers
- PHPUnit-ready project structure

## Installation

Install Delta with Composer:

```bash
composer require arefshojaei/delta
```

Or clone the repository directly:

```bash
git clone https://github.com/ArefShojaei/Delta.git
cd Delta
composer install
```

## Requirements

- PHP 8.2 or newer is recommended.
- Composer

## Quick Start

Create a public entrypoint:

```php
<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Delta\Application\DeltaFactory;
use Project\App\AppModule;

$app = DeltaFactory::createApp(AppModule::class);

$app->configure([
    "env" => [
        "path" => dirname(__DIR__) . "/.env",
    ],
    "storage" => [
        "cache" => [
            "path" => dirname(__DIR__) . "/storage/framework/cache",
        ],
        "logging" => [
            "path" => dirname(__DIR__) . "/storage/logs",
        ],
    ],
]);

$app->run();
```

Create a root module:

```php
<?php

namespace Project\App;

use Delta\Components\Layer\Attributes\Module;

#[Module(controllers: [AppController::class])]
final class AppModule {}
```

Create a controller:

```php
<?php

namespace Project\App;

use Delta\Components\Routing\Attributes\Get;
use Delta\Components\Http\{Request, Response};
use Delta\Components\Layer\Attributes\Controller;

#[Controller]
final class AppController
{
    #[Get("/")]
    public function index(Request $request, Response $response): void
    {
        $response->json([
            "message" => "Welcome to Delta",
        ]);
    }
}
```

Run your app with PHP's built-in server:

```bash
php -S 127.0.0.1:8000 -t public
```

## Recommended Application Structure

```text
project/
├── public/
│   └── index.php
├── src/
│   ├── App/
│   │   ├── AppModule.php
│   │   └── AppController.php
│   ├── User/
│   │   ├── UserModule.php
│   │   ├── UserController.php
│   │   └── UserService.php
│   └── Auth/
│       ├── AuthModule.php
│       ├── AuthController.php
│       └── AuthService.php
├── storage/
│   ├── framework/
│   │    └── cache/
│   └── logs/
├── vendor
├── .env
└── composer.json
```

Feature modules can be imported into the root module:

```php
<?php

namespace Project\App;

use Delta\Components\Layer\Attributes\Module;

use Project\Auth\AuthModule;
use Project\User\UserModule;

#[
    Module(
        controllers: [AppController::class],
        imports: [AuthModule::class, UserModule::class],
    ),
]
final class AppModule {}
```

## Modules

Modules are the top-level building blocks of a Delta application.

```php
use Delta\Components\Layer\Attributes\Module;

#[
    Module(
        controllers: [UserController::class],
        providers: [UserService::class],
        imports: [],
        exports: [],
    ),
]
final class UserModule {}
```

Available module options:

- `controllers`: controller classes registered by this module
- `providers`: injectable services available to this module's controllers
- `imports`: other modules this module depends on
- `exports`: classes exposed to modules that import this module

## Controllers

Controllers group related HTTP endpoints.

```php
use Delta\Components\Layer\Attributes\Controller;

#[Controller("/users", name: "users")]
final class UserController {}
```

The first argument is the route prefix. The optional `name` is used as a route alias prefix.

## Routing

Delta routes are declared with PHP attributes on public controller methods.

```php
use Delta\Components\Routing\Attributes\{Get, Post, Put, Patch, Delete};

#[Get('/')]
public function index(Request $request, Response $response): void {}

#[Get('/{id}', name: 'show')]
public function show(Request $request, Response $response): void {}

#[Post('/')]
public function store(Request $request, Response $response): void {}

#[Put('/{id}')]
public function update(Request $request, Response $response): void {}

#[Patch('/{id}')]
public function patch(Request $request, Response $response): void {}

#[Delete('/{id}')]
public function destroy(Request $request, Response $response): void {}
```

Route parameters are available through the request object:

```php
$id = $request->params("id");
```

Named routes can be resolved with the `route()` helper:

```php
$url = route("users.show");
```

## Providers

Providers are regular classes that can be injected into controllers. Mark a provider with `#[Injectable]`, then register it in the module.

```php
<?php

namespace Project\User;

use Delta\Components\Layer\Attributes\Injectable;

#[Injectable]
final class UserService
{
    public function all(): array
    {
        return [["id" => 1, "name" => "Aref Shojaei"]];
    }
}
```

```php
#[Module(controllers: [UserController::class], providers: [UserService::class])]
final class UserModule {}
```

```php
final class UserController
{
    public function __construct(private UserService $service) {}
}
```

## Request

The `Request` object gives access to server headers, query parameters, JSON body data, dynamic route parameters, and temporary request-scoped properties.

```php
$request->method();
$request->uri();
$request->route();
$request->ip();
$request->host();
$request->agent();
$request->query("search");
$request->body("email");
$request->params("id");
```

Dynamic request properties are also supported:

```php
$request->userId = 1;
$userId = $request->userId;
```

## Response

The `Response` object can send JSON, HTML, headers, status codes, redirects, cookies, and sessions.

```php
$response->status(201);

$response->json([
    "created" => true,
]);
```

```php
$response->html("<h1>Hello Delta</h1>");
```

```php
$response->redirect("/login");
```

## Middleware

Middleware classes implement `Delta\Common\Interfaces\Middleware`.

```php
<?php

namespace Project\Http\Middleware;

use Closure;

use Delta\Common\Interfaces\Middleware;
use Delta\Components\Http\{Request, Response};

final class AuthMiddleware implements Middleware
{
    public function handle(
        Request $request,
        Response $response,
        Closure $next,
    ): bool {
        if (!$request->header("Authorization")) {
            $response->status(401);
            $response->json(["message" => "Unauthorized"]);

            return false;
        }

        return $next();
    }
}
```

Attach middleware to a controller or route:

```php
use Delta\Components\Routing\Attributes\Middleware;

#[Middleware([AuthMiddleware::class])]
final class UserController
{
    #[Get("/profile")]
    public function profile(Request $request, Response $response): void {}
}
```

Delta also ships with these middleware classes:

- `Delta\Middlewares\CORS`
- `Delta\Middlewares\SecureHttpHeader`
- `Delta\Middlewares\RateLimiter`

## Configuration

Use `configure()` when creating the app:

```php
$app->configure([
    "env" => [
        "path" => dirname(__DIR__) . "/.env",
    ],
    "storage" => [
        "cache" => [
            "path" => dirname(__DIR__) . "/storage/framework/cache",
        ],
        "logging" => [
            "path" => dirname(__DIR__) . "/storage/logs",
        ],
    ],
    "rate_limiter" => [
        "max_requests" => 60,
        "decay_seconds" => 60,
    ],
]);
```

Read config values anywhere with:

```php
use Delta\Components\Config\Config;

$cachePath = Config::get("storage.cache.path");
```

## Environment

Create a `.env` file:

```dotenv
APP_NAME=Delta
APP_ENV=local
```

Read environment values:

```php
use Delta\Components\Env\DotEnvironment;

$name = DotEnvironment::get("APP_NAME", "Delta");
```

## Cache

Delta includes a simple file cache.

```php
use Delta\Components\Cache\Cache;

Cache::set("users", [["id" => 1]], 60);

$users = Cache::get("users", []);

Cache::delete("users");
Cache::clear();
```

Make sure `storage.cache.path` points to a writable directory.

## Logging

```php
use Delta\Components\Logging\Logger;

$logger = Logger::getInstance();

$logger->info("Application started");
$logger->warn("Something may need attention");
$logger->error("Something failed");
$logger->success("Operation completed");
```

Make sure `storage.logging.path` points to a writable directory.

## Error Routes

Delta includes route attributes for common error handlers:

```php
use Delta\Components\Routing\Attributes\{NotFound, MethodNotAllowed, ServerError};

#[NotFound]
public function notFound(Request $request, Response $response): void
{
    $response->status(404);
    $response->json(['message' => 'Not found']);
}
```

## Testing

Run the test suite:

```bash
composer test
```

## Request Lifecycle

<img width="100%" alt="Delta request lifecycle" src="https://github.com/user-attachments/assets/5acc4a56-0f96-4370-a1a4-7fae87b3a76f" />

At a high level:

1. `public/index.php` loads Composer autoload.
2. `DeltaFactory` creates the application instance.
3. The app configuration is registered.
4. Core service providers are bootstrapped.
5. The root module is scanned.
6. Controllers, providers, imports, and exports are registered.
7. The HTTP kernel resolves the current route.
8. Middleware is applied.
9. The matched controller method sends a response.

## Contributing

Contributions are welcome. Please keep changes focused and include tests for framework behavior when possible.

```bash
git clone https://github.com/ArefShojaei/Delta.git
cd Delta
composer install
composer test
```

## License

Delta is open-sourced software licensed under the [MIT license](LICENSE).
