<?php

namespace Tests\Unit\Components;

use Delta\Components\Cache\Cache;
use Delta\Components\Config\Config;

use Tests\Support\TestCase;

final class CacheTest extends TestCase
{
    private string $cachePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetStaticProperty(Config::class, "data", []);
        $this->cachePath = $this->tempDir("delta-cache-");

        Config::set([
            "storage" => [
                "cache" => ["path" => $this->cachePath],
            ],
        ]);
    }

    public function testSetGetHasAndDeleteCacheEntries(): void
    {
        $this->assertNotFalse(Cache::set("user:1", ["id" => 1], 3600));
        $this->assertTrue(Cache::has("user:1"));
        $this->assertSame(["id" => 1], Cache::get("user:1"));
        $this->assertTrue(Cache::delete("user:1"));
        $this->assertFalse(Cache::has("user:1"));
    }

    public function testClearRemovesAllCacheFiles(): void
    {
        Cache::set("one", 1);
        Cache::set("two", 2);

        $this->assertNotEmpty(
            glob($this->cachePath . DIRECTORY_SEPARATOR . "*.cache"),
        );
        $this->assertTrue(Cache::clear());
        $this->assertSame(
            [],
            glob($this->cachePath . DIRECTORY_SEPARATOR . "*.cache") ?: [],
        );
    }

    public function testHasRemovesExpiredEntries(): void
    {
        Cache::set("expiring", "value", 60);
        $file =
            $this->cachePath .
            DIRECTORY_SEPARATOR .
            sha1("expiring") .
            ".cache";
        $data = unserialize(file_get_contents($file));
        $data["expires"] = time() - 1;
        file_put_contents($file, serialize($data));

        $this->assertFalse(Cache::has("expiring"));
        $this->assertFileDoesNotExist($file);
    }
}
