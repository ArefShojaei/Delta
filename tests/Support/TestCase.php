<?php

namespace Tests\Support;

use ReflectionClass;
use RuntimeException;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    private array $cleanupPaths = [];

    protected function tempDir(string $prefix = "delta-tests-"): string
    {
        $path =
            sys_get_temp_dir() .
            DIRECTORY_SEPARATOR .
            $prefix .
            uniqid("", true);

        if (!mkdir($path, 0777, true) && !is_dir($path)) {
            throw new RuntimeException(
                "Failed to create temporary directory: {$path}",
            );
        }

        $this->cleanupPaths[] = $path;

        return $path;
    }

    protected function tempFile(string $prefix, string $contents = ""): string
    {
        $path =
            $this->tempDir($prefix) .
            DIRECTORY_SEPARATOR .
            uniqid("file-", true);
        file_put_contents($path, $contents);

        $this->cleanupPaths[] = $path;

        return $path;
    }

    protected function resetStaticProperty(
        string $class,
        string $property,
        mixed $value,
    ): void {
        $reflection = new ReflectionClass($class);
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);
        $prop->setValue(null, $value);
    }

    protected function tearDown(): void
    {
        $this->cleanupPaths = array_reverse($this->cleanupPaths);

        foreach ($this->cleanupPaths as $path) {
            $this->removePath($path);
        }

        $this->cleanupPaths = [];

        parent::tearDown();
    }

    private function removePath(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }

        if (is_file($path) || is_link($path)) {
            @unlink($path);

            return;
        }

        foreach (glob($path . DIRECTORY_SEPARATOR . "*") ?: [] as $child) {
            $this->removePath($child);
        }

        @rmdir($path);
    }
}
