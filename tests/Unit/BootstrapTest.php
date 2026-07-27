<?php

namespace Tests\Unit;

use Delta\Bootstrap\Bootstrap;
use Delta\Bootstrap\Interfaces\Bootstrap as BootstrapInterface;
use Delta\Components\Container\Container;

use Tests\Support\TestCase;

final class BootstrapTest extends TestCase
{
    public function testImplementsBootstrapInterface(): void
    {
        $interfaces = class_implements(Bootstrap::class);

        $this->assertArrayHasKey(BootstrapInterface::class, $interfaces);
    }

    public function testConstructorAcceptsContainer(): void
    {
        $bootstrap = new Bootstrap(new Container());

        $this->assertInstanceOf(Bootstrap::class, $bootstrap);
    }
}
