<?php

namespace Delta\Components\Logging\Interfaces;

interface Logger
{
    public function info(string $message): void;

    public function warn(string $message): void;

    public function error(string $message): void;

    public function success(string $message): void;
}
