<?php

namespace Tests\Fixtures\Containers;

use Delta\Common\Interfaces\Singleton;

final class TestSingletonService implements Singleton
{
    private static ?self $instance = null;

    private function __construct() {}

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }
}
