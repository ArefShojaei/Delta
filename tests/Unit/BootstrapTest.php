<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use RuntimeException;

use Delta\Bootstrap\Bootstrap;
use Delta\Bootstrap\Interfaces\Bootstrap as IBootstrap;
use Delta\Bootstrap\Interfaces\ServiceProvider;
use Delta\Components\Container\Container;

final class BootstrapTest extends TestCase
{
    private Bootstrap $bootstrap;
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
        $this->bootstrap = new Bootstrap($this->container);
    }

    /**
     * @test
     */
    public function implementsBootstrapInterface(): void
    {
        $interfaces = class_implements(Bootstrap::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IBootstrap::class, $interfaces);
    }

    /**
     * @test
     */
    public function bootstrapConstructor(): void
    {
        $this->assertInstanceOf(Bootstrap::class, $this->bootstrap);
    }

    /**
     * @test
     */
    public function bootstrapThrowsExceptionWhenConfigFileNotFound(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Configuration file not found');

        $this->bootstrap->init();
    }

    /**
     * @test
     */
    public function bootstrapHasInitMethod(): void
    {
        $this->assertTrue(method_exists($this->bootstrap, 'init'));
    }

    /**
     * @test
     */
    public function bootstrapContainsContainer(): void
    {
        $this->assertInstanceOf(Container::class, $this->container);
    }
}

// Mock ServiceProvider for testing
class MockServiceProvider implements ServiceProvider
{
    public static bool $registered = false;
    public static bool $booted = false;

    public function register(Container $container): void
    {
        self::$registered = true;
    }

    public function boot(Container $container): void
    {
        self::$booted = true;
    }
}
