<?php

namespace Tests\Unit\Components;

use Delta\Components\Config\Config;
use Delta\Components\Logging\Logger;
use Delta\Components\Logging\Interfaces\Logger as LoggerInterface;

use Tests\Support\TestCase;

final class LoggerTest extends TestCase
{
    private string $logPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetStaticProperty(Config::class, "data", []);
        $this->logPath = $this->tempDir("delta-log-");

        Config::set([
            "storage" => [
                "logging" => ["path" => $this->logPath],
            ],
        ]);
    }

    public function testLoggerImplementsInterface(): void
    {
        $interfaces = class_implements(Logger::class);

        $this->assertArrayHasKey(LoggerInterface::class, $interfaces);
    }

    public function testLoggerIsSingleton(): void
    {
        $first = Logger::getInstance();
        $second = Logger::getInstance();

        $this->assertSame($first, $second);
    }

    public function testLoggerWritesMessageToFile(): void
    {
        Logger::getInstance()->info("framework booted");

        $content = file_get_contents(
            $this->logPath . DIRECTORY_SEPARATOR . "app.log",
        );

        $this->assertStringContainsString("INFO", $content);
        $this->assertStringContainsString("framework booted", $content);
    }
}
