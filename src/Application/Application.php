<?php

namespace Delta\Application;

use Delta\Application\Attributes\Module;
use Delta\Components\Reflection\Providers\{
    ClassReflectionProvider,
    MethodReflectionProvider
};
use Delta\Components\Routing\Attributes\{
    Controller,
    Route
};
use Delta\Components\Routing\Router;
use Delta\Components\Http\HttpBuilder;
use ReflectionMethod;
use stdClass;

final class Application
{
    private object $router;

    public function __construct(private string $app)
    {
        $appModuleReflectionProvider = new ClassReflectionProvider($app, Module::class);

        $this->router = new Router;

        $this->applyControllers($appModuleReflectionProvider);
    }

    private function applyControllers(object $module)
    {
        $controllers = $module->descriptor->options["controllers"];

        foreach ($controllers as $controller) {
            $controllerReflectionProvider = new ClassReflectionProvider($controller, Controller::class);

            // * @MetaData
            $prefix = "/" . ltrim($controllerReflectionProvider->descriptor->prefix, "/");


            $methods = $controllerReflectionProvider->methods;

            foreach ($methods as $method) {
                $methodReflectionProvider = new MethodReflectionProvider($method, Route::class);

                // * @MetaData
                $httpMethod = $methodReflectionProvider->descriptor->method;

                $path = $prefix . $methodReflectionProvider->descriptor->path;

                $callback = $methodReflectionProvider->callback;

                $this->router->addRoute($httpMethod, $path, $callback);


                
            }
        }
    }

    public function run(): void
    {
        $httpBuilder = (new HttpBuilder)
            ->setRequest()
            ->setResponse()
            ->setRouter($this->router)
            ->build();

        $httpBuilder->listen();
    }
}
