<?php

namespace Delta\Components\Json\Interfaces;


interface Json
{
    public static function encode(array $body): string;

    public static function decode(string $body, bool $associative = false): array|object;
}
