<?php

namespace Tests\Unit\Components;

use Delta\Components\Config\Config;

use Tests\Support\TestCase;

final class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->resetStaticProperty(Config::class, "data", []);
    }

    public function testSetAndGetNestedValues(): void
    {
        Config::set([
            "app" => ["name" => "Delta"],
            "storage" => ["cache" => ["path" => "/tmp/cache"]],
        ]);

        $this->assertSame("Delta", Config::get("app.name"));
        $this->assertSame("/tmp/cache", Config::get("storage.cache.path"));
    }

    public function testGetReturnsDefaultForMissingKey(): void
    {
        Config::set(["app" => ["name" => "Delta"]]);

        $this->assertSame("fallback", Config::get("app.version", "fallback"));
    }

    public function testAllReturnsCurrentConfiguration(): void
    {
        Config::set(["app" => ["name" => "Delta"]]);

        $this->assertSame(["app" => ["name" => "Delta"]], Config::all());
    }
}
