<?php

namespace Tests\Unit\Components;

use Delta\Components\Store\Store;
use Delta\Components\Store\Enums\StoreType;
use Delta\Components\Store\Interfaces\Store as StoreInterface;
use Tests\Fixtures\Http\{DemoExport, DemoProvider};

use Tests\Support\TestCase;

final class StoreTest extends TestCase
{
    private Store $store;

    protected function setUp(): void
    {
        parent::setUp();
        $this->store = new Store();
    }

    public function testImplementsStoreInterface(): void
    {
        $interfaces = class_implements(Store::class);

        $this->assertArrayHasKey(StoreInterface::class, $interfaces);
    }

    public function testSetAndGetDependencies(): void
    {
        $this->store->set("module", StoreType::PROVIDER, DemoProvider::class);
        $this->store->set("module", StoreType::EXPORT, DemoExport::class);

        $this->assertSame(
            [DemoProvider::class],
            $this->store->get("module", StoreType::PROVIDER),
        );
        $this->assertSame(
            [DemoExport::class],
            $this->store->get("module", StoreType::EXPORT),
        );
    }

    public function testSetDoesNotDuplicateDependencies(): void
    {
        $this->store->set("module", StoreType::PROVIDER, DemoProvider::class);
        $this->store->set("module", StoreType::PROVIDER, DemoProvider::class);

        $this->assertCount(1, $this->store->get("module", StoreType::PROVIDER));
    }

    public function testSetRecursiveAddsMultipleDependencies(): void
    {
        $this->store->setRecursive("module", StoreType::EXPORT, [
            DemoExport::class,
            DemoProvider::class,
        ]);

        $this->assertCount(2, $this->store->get("module", StoreType::EXPORT));
    }

    public function testHasAndAllExposeStoreState(): void
    {
        $this->store->set("module", StoreType::PROVIDER, DemoProvider::class);

        $this->assertTrue($this->store->has("module", StoreType::PROVIDER));
        $this->assertSame(
            $this->store->get("module", StoreType::PROVIDER),
            $this->store->all("module")["providers"],
        );
    }
}
