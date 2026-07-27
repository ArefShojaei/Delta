<?php

namespace Tests\Unit;

use Delta\Components\Config\Config;
use Delta\Components\Container\Container;
use Delta\Application\{Application, DeltaFactory};
use Delta\Application\Exceptions\{
    InvalidConfigurationExcepiton,
    InvalidModuleException,
};

use Tests\Support\TestCase;

final class ApplicationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resetStaticProperty(Config::class, "data", []);
    }

    public function testConfigureStoresApplicationConfig(): void
    {
        $application = new Application(MockAppModule::class, new Container());

        $result = $application->configure([
            "env" => ["path" => "/tmp/app.env"],
            "storage" => ["cache" => ["path" => "/tmp/cache"]],
        ]);

        $this->assertSame($application, $result);
        $this->assertSame("/tmp/app.env", Config::get("env.path"));
        $this->assertSame("/tmp/cache", Config::get("storage.cache.path"));
    }

    public function testConfigureRejectsEmptyConfig(): void
    {
        $this->expectException(InvalidConfigurationExcepiton::class);

        $application = new Application(MockAppModule::class, new Container());
        $application->configure([]);
    }

    public function testFactoryCreatesApplication(): void
    {
        $application = DeltaFactory::createApp(MockAppModule::class);

        $this->assertInstanceOf(Application::class, $application);
    }

    public function testFactoryRejectsEmptyModule(): void
    {
        $this->expectException(InvalidModuleException::class);

        DeltaFactory::createApp("");
    }
}

final class MockAppModule {}
