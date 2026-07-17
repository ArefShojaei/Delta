<?php

namespace Delta\Components\Logging;

use Delta\Common\Interfaces\Singleton as ISingleton;
use Delta\Components\Logging\{
    Abilities\CanLogMessage,
    Interfaces\CanLogMessage as ICanLogMessage,
};

final class Logger extends Log implements ISingleton, ICanLogMessage
{
    use CanLogMessage;

    private static ?self $instance = null;

    private function __construct() {}

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
