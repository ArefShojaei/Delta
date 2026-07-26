<?php

namespace Delta\Components\Logging;

use Delta\Components\Config\Config;
use Delta\Components\Logging\Enums\LogLevelType;
use Delta\Components\Logging\Exceptions\LoggerException;

abstract class Log
{
    protected function dispatch(string $log): void
    {
        $path = Config::get("storage.logging.path");

        if (!$path) throw new LoggerException("Logging path is not defined!");

        $file = $path . "/app.log";

        file_put_contents($file, $log, FILE_APPEND);
    }

    protected function createMessage(
        string $message,
        LogLevelType $type,
    ): string {
        $date = date("Y-m-d H:m:s");

        $content = "[{$date}] {$this->getType($type)} {$message}";

        return $content;
    }

    private function getType(LogLevelType $type): string
    {
        return strtoupper($type->name);
    }
}
