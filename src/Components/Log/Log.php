<?php

namespace Delta\Components\Log;

use Delta\Components\Log\Enums\LogLevelType;


class Log
{
    protected function createMessage(
        string $message,
        LogLevelType $type,
    ): string {
        return "[" . $this->getType($type) . "] {$message}" . PHP_EOL;
    }

    private function getType(LogLevelType $type): string
    {
        return strtoupper($type->name);
    }
}
