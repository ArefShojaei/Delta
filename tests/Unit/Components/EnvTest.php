<?php

namespace Tests\Unit\Components;

use PHPUnit\Framework\TestCase;

use Delta\Components\Env\{
    DotEnvEnvironment,
    interfaces\DotEnvEnvironment as IDotEnvEnvironment,
};

final class EnvTest extends TestCase
{
    private DotEnvEnvironment $env;

    protected function setUp(): void
    {
        parent::setUp();

        $this->env = new DotEnvEnvironment();

        $this->env->load($this->getFilePath());
    }

    private function getRootDirectoryPath(): string
    {
        return dirname(__DIR__, 3);
    }

    private function getFilePath(): string
    {
        return $this->getRootDirectoryPath() . "/.env";
    }

    /**
     * @test
     */
    public function implementsEnvInterface(): void
    {
        $interfaces = class_implements(DotEnvEnvironment::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IDotEnvEnvironment::class, $interfaces);
    }

    /**
     * @test
     */
    public function isEnvFileLoaded(): void
    {
        $this->assertIsArray($_ENV);
        $this->assertNotEmpty($_ENV);
    }

    /**
     * @test
     */
    public function getVariableValueFromEnvFileByValidKey(): void
    {
        $name = $this->env->get("APP_NAME");

        $this->assertIsString($name);
        $this->assertEquals("Delta", $name);
    }

    /**
     * @test
     */
    public function getDefaultVariableValueFromEnvFileByInvalidKey(): void
    {
        $default = "1.0.0";

        $version = $this->env->get("APP_VERSION", $default);

        $this->assertIsString($version);
        $this->assertEquals($default, $version);
    }
}
