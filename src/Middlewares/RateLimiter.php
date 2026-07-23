<?php

namespace Delta\Middlewares;

use Closure;

use Delta\Components\Cache\Cache;
use Delta\Common\Interfaces\Middleware as IMiddleware;
use Delta\Components\Http\{HttpStatus, Request, Response};

final class RateLimiter implements IMiddleware
{
    private const MAX_REQUESTS = 60;

    private const DECAY_SECONDS = 60;

    public function handle(
        Request $request,
        Response $response,
        Closure $next,
    ): bool {
        $ip = $request->ip();
        $key = "rate_limit:{$ip}";

        if (!Cache::has($key)) {
            Cache::set($key, 0, self::DECAY_SECONDS);
        }

        $attempts = Cache::get($key);

        if ($attempts >= self::MAX_REQUESTS) {
            $response->status(HttpStatus::HTTP_TOO_MANY_REQUESTS);
            $response->json([
                "error" => "Too Many Requests!",
                "message" =>
                    "Please wait in " . self::DECAY_SECONDS . " seconds",
            ]);

            return false;
        }

        Cache::set($key, $attempts + 1, self::DECAY_SECONDS);

        return $next();
    }
}
