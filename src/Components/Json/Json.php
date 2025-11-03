<?php

namespace Delta\Components\Json;

use Delta\Components\Json\Interfaces\Json as IJson;


final class Json implements IJson
{
    public static function encode(array $body): string
    {
        return json_encode($body, JSON_UNESCAPED_UNICODE);
    }

    public static function decode(string $body, bool $associative = false): array|object {
        return json_decode($body, $associative);
    }
}
