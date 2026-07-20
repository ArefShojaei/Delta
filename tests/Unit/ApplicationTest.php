<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use Delta\Application\Application;
use Delta\Application\Interfaces\Application as IApplication;
use Delta\Application\Exceptions\InvalidConfigurationExcepiton;
use Delta\Components\Container\Container;

final class ApplicationTest extends TestCase
{
    private Application $application;
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
        $this->application = new Application(
            MockAppModule::class,
            $this->container
        );
    }

    /**
     * @test
     */
    public function implementsApplicationInterface(): void
    {
        $interfaces = class_implements(Application::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IApplication::class, $interfaces);
    }

    /**
     * @test
     */
    public function applicationConstructor(): void
    {
        $this->assertInstanceOf(Application::class, $this->application);
    }

    /**
     * @test
     */
    public function configureThrowsExceptionWithEmptyConfig(): void
    {
        $this->expectException(InvalidConfigurationExcepiton::class);
        $this->expectExceptionMessage("Config can not be empty!");

        $this->application->configure([]);
    }

    /**
     * @test
     */
    public function configureReturnsApplicationInstance(): void
    {
        // Create a temporary .env file for testing
        $envFile = sys_get_temp_dir() . '/.env.test';
        file_put_contents($envFile, "APP_NAME=Test\nAPP_ENV=testing\n");

        try {
            $result = $this->application->configure(['env_path' => $envFile]);

            $this->assertInstanceOf(Application::class, $result);
        } finally {
            @unlink($envFile);
        }
    }

    /**
     * @test
     */
    public function applicationHasRunMethod(): void
    {
        $this->assertTrue(method_exists($this->application, 'run'));
    }

    /**
     * @test
     */
    public function applicationHasConfigureMethod(): void
    {
        $this->assertTrue(method_exists($this->application, 'configure'));
    }

    /**
     * @test
     */
    public function applicationAcceptsModuleAsString(): void
    {
        $app = new Application(MockAppModule::class, $this->container);

        $this->assertInstanceOf(Application::class, $app);
    }

    /**
     * @test
     */
    public function applicationAcceptsModuleAsObject(): void
    {
        $module = new MockAppModule();
        $app = new Application($module, $this->container);

        $this->assertInstanceOf(Application::class, $app);
    }

    /**
     * @test
     */
    public function applicationContainsContainer(): void
    {
        $this->assertInstanceOf(Container::class, $this->container);
    }
}

// Mock Module for testing
class MockAppModule
{
    public function register(): void
    {
        // Mock implementation
    }
}
