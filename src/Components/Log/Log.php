<?php

namespace Delta\Components\Log;

use Delta\Components\Log\Enums\LogLevelTypeEnum;


class Log 
{
    protected function createMessage(string $message, LogLevelTypeEnum $type): string
    {
        return "[" . $this->getType($type) . "] {$message}" . PHP_EOL;
    }

    private function getType(LogLevelTypeEnum $type): string
    {
        return strtoupper($type->name);
    }
}