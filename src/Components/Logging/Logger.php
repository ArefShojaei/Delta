<?php

namespace Delta\Components\Logging;

use Delta\Components\Logging\Enums\LogLevelType;
use Delta\Common\Interfaces\Singleton as ISingleton;
use Delta\Components\Logging\Interfaces\Logger as ILogger;

final class Logger extends Log implements ISingleton, ILogger
{
    private static ?self $instance = null;

    private function __construct() {}

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function info(string $message): void
    {
        $log = $this->createMessage($message, LogLevelType::INFO);

        $this->dispatch($log);
    }

    public function warn(string $message): void
    {
        $log = $this->createMessage($message, LogLevelType::WARN);

        $this->dispatch($log);
    }

    public function error(string $message): void
    {
        $log = $this->createMessage($message, LogLevelType::ERROR);

        $this->dispatch($log);
    }

    public function success(string $message): void
    {
        $log = $this->createMessage($message, LogLevelType::SUCCESS);

        $this->dispatch($log);
    }
}
