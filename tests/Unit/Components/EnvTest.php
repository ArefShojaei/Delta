<?php

namespace Tests\Unit\Components;

use RuntimeException;

use Delta\Components\Env\DotEnvironment;
use Delta\Components\Env\interfaces\DotEnvironment as DotEnvironmentInterface;

use Tests\Support\TestCase;

final class EnvTest extends TestCase
{
    public function testImplementsEnvInterface(): void
    {
        $interfaces = class_implements(DotEnvironment::class);

        $this->assertArrayHasKey(DotEnvironmentInterface::class, $interfaces);
    }

    public function testLoadReadsValuesFromDotenvFile(): void
    {
        $path = $this->tempFile(
            "delta-env-",
            "APP_NAME=Delta Test\nAPP_ENV=testing\n",
        );

        $env = new DotEnvironment();
        $env->load($path);

        $this->assertSame("Delta Test", DotEnvironment::get("APP_NAME"));
        $this->assertSame("testing", DotEnvironment::get("APP_ENV"));
        $this->assertSame(
            "fallback",
            DotEnvironment::get("NOT_DEFINED", "fallback"),
        );
    }

    public function testLoadMissingFileThrowsRuntimeException(): void
    {
        $this->expectException(RuntimeException::class);

        $dotenv = new DotEnvironment();

        $dotenv->load(
            $this->tempDir("delta-missing-") . DIRECTORY_SEPARATOR . ".env",
        );
    }
}
