<?php

namespace Tests\Unit\Components;

use PHPUnit\Framework\TestCase;
use Closure;

use Delta\Components\Container\Container;
use Delta\Components\Container\Interfaces\Container as IContainer;

final class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    /**
     * @test
     */
    public function implementsContainerInterface(): void
    {
        $interfaces = class_implements(Container::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IContainer::class, $interfaces);
    }

    /**
     * @test
     */
    public function bindClassToContainer(): void
    {
        $this->container->bind('TestClass', TestServiceClass::class);

        $bindings = $this->container->getBindings();

        $this->assertArrayHasKey('TestClass', $bindings);
        $this->assertIsArray($bindings['TestClass']);
    }

    /**
     * @test
     */
    public function resolveBindingFromContainer(): void
    {
        $this->container->bind('TestClass', TestServiceClass::class);

        $instance = $this->container->resolve('TestClass');

        $this->assertInstanceOf(TestServiceClass::class, $instance);
    }

    /**
     * @test
     */
    public function resolveNonExistentBindingReturnsNull(): void
    {
        $instance = $this->container->resolve('NonExistent');

        $this->assertNull($instance);
    }

    /**
     * @test
     */
    public function singletonBindingReturnsSameInstance(): void
    {
        $this->container->singleton('SingletonService', TestSingletonService::class);

        $instance1 = $this->container->resolve('SingletonService');
        $instance2 = $this->container->resolve('SingletonService');

        $this->assertSame($instance1, $instance2);
    }

    /**
     * @test
     */
    public function bindingWithClosureCallsClosure(): void
    {
        $called = false;

        $this->container->bind('ClosureService', function($container) use (&$called) {
            $called = true;
            return new TestServiceClass();
        });

        $instance = $this->container->resolve('ClosureService');

        $this->assertTrue($called);
        $this->assertInstanceOf(TestServiceClass::class, $instance);
    }

    /**
     * @test
     */
    public function getBindingsReturnsAllBindings(): void
    {
        $this->container->bind('Service1', TestServiceClass::class);
        $this->container->bind('Service2', TestServiceClass::class);

        $bindings = $this->container->getBindings();

        $this->assertCount(2, $bindings);
        $this->assertArrayHasKey('Service1', $bindings);
        $this->assertArrayHasKey('Service2', $bindings);
    }

    /**
     * @test
     */
    public function getInstancesReturnsAllResolvedInstances(): void
    {
        $this->container->bind('Service1', TestServiceClass::class);

        $this->container->resolve('Service1');

        $instances = $this->container->getInstances();

        $this->assertArrayHasKey('Service1', $instances);
        $this->assertInstanceOf(TestServiceClass::class, $instances['Service1']);
    }

    /**
     * @test
     */
    public function containerCanResolveMultipleDifferentServices(): void
    {
        $this->container->bind('Service1', TestServiceClass::class);
        $this->container->bind('Service2', AnotherTestService::class);

        $service1 = $this->container->resolve('Service1');
        $service2 = $this->container->resolve('Service2');

        $this->assertInstanceOf(TestServiceClass::class, $service1);
        $this->assertInstanceOf(AnotherTestService::class, $service2);
        $this->assertNotSame($service1, $service2);
    }
}

// Test helper classes
class TestServiceClass
{
    public function getMessage(): string
    {
        return 'Test Service';
    }
}

class AnotherTestService
{
    public function getName(): string
    {
        return 'Another Service';
    }
}

class TestSingletonService
{
    public static function getInstance(): self
    {
        static $instance = null;
        
        if ($instance === null) {
            $instance = new self();
        }
        
        return $instance;
    }
}
