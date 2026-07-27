<?php

namespace Tests\Unit;

use Delta\Components\Container\Container;
use Delta\Components\Http\{Http, Request, Response};
use Delta\Components\Logging\Logger;
use Delta\Components\Routing\Router;
use Delta\Components\Store\Store;
use Delta\Providers\{
    DotEnvironmentServiceProvider,
    HttpServiceProvider,
    LoggingServiceProvider,
    RouterServiceProvider,
    StoreServiceProvider,
};

use Tests\Support\TestCase;

final class ProvidersTest extends TestCase
{
    public function testRouterServiceProviderRegistersRouter(): void
    {
        $container = new Container();
        (new RouterServiceProvider())->register($container);

        $this->assertInstanceOf(
            Router::class,
            $container->resolve(Router::class),
        );
    }

    public function testStoreServiceProviderRegistersStore(): void
    {
        $container = new Container();
        (new StoreServiceProvider())->register($container);

        $this->assertInstanceOf(
            Store::class,
            $container->resolve(Store::class),
        );
    }

    public function testLoggingServiceProviderRegistersLoggerSingleton(): void
    {
        $container = new Container();
        (new LoggingServiceProvider())->register($container);

        $this->assertSame(
            $container->resolve(Logger::class),
            $container->resolve(Logger::class),
        );
    }

    public function testDotEnvironmentProviderRegistersEnvironmentService(): void
    {
        $container = new Container();
        (new DotEnvironmentServiceProvider())->register($container);

        $this->assertNotNull(
            $container->resolve(\Delta\Components\Env\DotEnvironment::class),
        );
    }

    public function testHttpServiceProviderRegistersHttpStack(): void
    {
        $container = new Container();
        (new RouterServiceProvider())->register($container);
        (new HttpServiceProvider())->register($container);

        $this->assertInstanceOf(
            Request::class,
            $container->resolve(Request::class),
        );
        $this->assertInstanceOf(
            Response::class,
            $container->resolve(Response::class),
        );
        $this->assertInstanceOf(Http::class, $container->resolve(Http::class));
    }
}
