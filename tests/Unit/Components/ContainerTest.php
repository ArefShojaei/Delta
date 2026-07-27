<?php

namespace Tests\Unit\Components;

use Delta\Components\Container\Container;
use Delta\Components\Container\Exceptions\ContainerException;
use Delta\Components\Container\Interfaces\Container as ContainerInterface;

use Tests\Support\TestCase;
use Tests\Fixtures\Containers\{
    AnotherTestService,
    TestService,
    TestSingletonService,
};

final class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    public function testImplementsContainerInterface(): void
    {
        $interfaces = class_implements(Container::class);

        $this->assertArrayHasKey(ContainerInterface::class, $interfaces);
    }

    public function testBindAndResolveConcreteClass(): void
    {
        $this->container->bind("service", TestService::class);

        $instance = $this->container->resolve("service");

        $this->assertInstanceOf(TestService::class, $instance);
    }

    public function testResolveUnknownBindingReturnsNull(): void
    {
        $this->assertNull($this->container->resolve("missing"));
    }

    public function testClosureBindingIsExecuted(): void
    {
        $called = false;

        $this->container->bind("factory", function () use (&$called) {
            $called = true;

            return new TestService();
        });

        $instance = $this->container->resolve("factory");

        $this->assertTrue($called);
        $this->assertInstanceOf(TestService::class, $instance);
    }

    public function testSingletonBindingReturnsSameInstance(): void
    {
        $this->container->singleton("singleton", TestSingletonService::class);

        $first = $this->container->resolve("singleton");
        $second = $this->container->resolve("singleton");

        $this->assertSame($first, $second);
    }

    public function testSingletonBindingRequiresSingletonContract(): void
    {
        $this->expectException(ContainerException::class);

        $this->container->singleton("broken", AnotherTestService::class);
        $this->container->resolve("broken");
    }

    public function testGetBindingsAndInstancesExposeContainerState(): void
    {
        $this->container->bind("service", TestService::class);
        $this->container->resolve("service");

        $this->assertArrayHasKey("service", $this->container->getBindings());
        $this->assertArrayHasKey("service", $this->container->getInstances());
    }
}
