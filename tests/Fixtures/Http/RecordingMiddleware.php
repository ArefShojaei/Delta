<?php

namespace Tests\Fixtures\Http;

use Closure;
use Delta\Common\Interfaces\Middleware;
use Delta\Components\Http\Request;
use Delta\Components\Http\Response;

final class RecordingMiddleware implements Middleware
{
    public static array $calls = [];

    public function handle(Request $request, Response $response, Closure $next): bool
    {
        self::$calls[] = static::class;

        return $next();
    }
}
