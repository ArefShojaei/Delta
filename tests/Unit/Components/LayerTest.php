<?php

namespace Tests\Unit\Components;

use Delta\Components\Container\Container;
use Delta\Components\Layer\Factory\LayerFactory;
use Delta\Components\Routing\{Router, RouteAlias};
use Delta\Components\Store\Enums\StoreType;
use Delta\Components\Store\Store;

use Tests\Support\TestCase;
use Tests\Fixtures\Http\{DemoModule, DemoProvider};

final class LayerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new Container();
        $this->container->bind(Router::class, Router::class);
        $this->container->bind(Store::class, Store::class);
        $this->resetStaticProperty(RouteAlias::class, "names", []);
    }

    public function testModuleLayerRegistersRoutesProvidersExportsAndImports(): void
    {
        $layer = LayerFactory::createModuleLayer(
            DemoModule::class,
            $this->container,
        );
        $layer->process();

        $router = $this->container->resolve(Router::class);
        $store = $this->container->resolve(Store::class);

        $this->assertArrayHasKey("/api/users", $router->getRoutes("GET"));
        $this->assertSame("/api/users", RouteAlias::getName("demo.users"));

        $this->assertContainsOnlyInstancesOf(
            DemoProvider::class,
            $store->get(DemoModule::class, StoreType::PROVIDER),
        );
    }
}
