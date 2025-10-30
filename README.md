<p align="center">
  <a href="https://github.com/ArefShojaei/Delta" target="blank"><img src="docs/Logo.png" width="120" alt="Delta Logo" /></a>
</p>

  <p align="center">A <a href="https://php.net" target="_blank">PHP</a> framework for building efficient and scalable server-side applications.</p>

# Quick start
```php
<?php

use Delta\Application\{
  Attributes\Module,
  DeltaFactory
};
use Delta\Components\Routing\Attributes\{
  Controller,
  Get
};



#[Controller()]
class AppController {
    #[Get()]
    public function index() {
        return "Welcome page";
    }
}


#[Module([
    "controllers" => [AppController::class],
])]
class AppModule {}



function bootstrap(string $appModule): void {
  $app = DeltaFactory::createApp(AppModule::class);

  $app->run();
}

bootstrap(AppModule::class)
```