<p align="center">
  <a href="https://github.com/ArefShojaei/Delta" target="blank"><img src="docs/Logo.png" width="200" alt="Delta Logo" /></a>
</p>

  <p align="center">A <a href="https://php.net" target="_blank">PHP</a> framework for building efficient and scalable server-side applications.</p>

## Request Lifecycle
<img src="./docs/Request-lifecycle.png" />

## Installation

> Using Composer
```bash
composer require arefshojaei/delta
```

> Or Using Git
```bash
git clone https://github.com/ArefShojaei/Delta.git
```


## Quick Start
> File: .env
```text
APP_NAME = Delta - PHP Framework
```
> File: server.php
```php
<?php

require_once __DIR__ . "/vendor/autoload.php";

use Delta\Application\DeltaFactory;
use Delta\Components\Http\{Request, Response};
use Delta\Components\Layer\Attributes\{Module, Controller, Injectable};
use Delta\Components\Routing\Attributes\Get;


#[Controller]
class AppController
{
    public function index(Request $request, Response $response): void
    {
        $response->json(); 
    }
}

#[Module([
    "controllers" => [AppController::class]
])]
class AppModule {}


function bootstrap(): void
{
    $app = DeltaFactory::createApp(AppModule::class);

    $app
      ->configure(["env_path" => __DIR__])
      ->run()
}

bootstrap()
```

#### How to run the App?
```bash
php -S localhost:8000 server.php
```