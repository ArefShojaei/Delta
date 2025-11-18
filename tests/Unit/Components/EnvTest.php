<?php

namespace Tests\Unit\Components;

use Delta\Components\Env\DotEnvEnvironment;
use Delta\Components\Env\interfaces\DotEnvEnvironment as IDotEnvEnvironment;
use PHPUnit\Framework\TestCase;


final class EnvTest extends TestCase
{
    private DotEnvEnvironment $env;

    
    protected function setUp(): void
    {
        parent::setUp();

        $this->env = new DotEnvEnvironment();

        $this->env->load($this->getRootDirectoryPath());
    }

    private function getRootDirectoryPath(): string
    {
        return dirname(__DIR__, 3);
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
