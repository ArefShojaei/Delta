<?php

namespace Delta\Components\Logging\Abilities;

use Delta\Components\Logging\Enums\LogLevelType as Log;

trait CanLogMessage
{
    public function info(string $message): string
    {
        return $this->createMessage($message, Log::INFO);
    }

    public function warn(string $message): string
    {
        return $this->createMessage($message, Log::WARN);
    }

    public function error(string $message): string
    {
        return $this->createMessage($message, Log::ERROR);
    }

    public function success(string $message): string
    {
        return $this->createMessage($message, Log::SUCCESS);
    }
}
