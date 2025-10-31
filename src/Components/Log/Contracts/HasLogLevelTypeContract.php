<?php

namespace Delta\Components\Log\Contracts;


interface HasLogLevelTypeContract
{
    public function info(string $message): string;
    public function warn(string $message): string;
    public function error(string $message): string;
    public function success(string $message): string;
}