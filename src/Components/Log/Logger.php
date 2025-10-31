<?php

namespace Delta\Components\Log;

use Delta\Application\Attributes\Log;
use Delta\Common\Contracts\SingletonContract;
use Delta\Components\Log\Contracts\HasLogLevelTypeContract;
use Delta\Components\Log\Mixins\HasLogLevelType;


final class Logger extends Log implements SingletonContract, HasLogLevelTypeContract
{
    use HasLogLevelType;

    private static ?self $instance = null;


    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}