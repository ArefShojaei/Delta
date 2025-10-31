<?php

namespace Delta\Components\Log\Mixins;

use Delta\Components\Log\Enums\LogLevelTypeEnum;


trait HasLogLevelType
{
    public function info(string $message): string
    {
        return $this->createMessage($message, LogLevelTypeEnum::INFO);
    }

    public function warn(string $message): string
    {
        return $this->createMessage($message, LogLevelTypeEnum::WARN);
    }

    public function error(string $message): string
    {
        return $this->createMessage($message, LogLevelTypeEnum::ERROR);
    }

    public function success(string $message): string
    {
        return $this->createMessage($message, LogLevelTypeEnum::SUCCESS);
    }
}