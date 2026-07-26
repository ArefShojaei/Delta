<?php

namespace Delta\Middlewares;

use Closure;

use Delta\Components\Cache\Cache;
use Delta\Components\Config\Config;
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
            $decaySeconds = Config::get(
                "rate_limiter.decay_seconds",
                self::DECAY_SECONDS,
            );

            Cache::set($key, 0, $decaySeconds);
        }

        $attempts = Cache::get($key);

        $maxRequests = Config::get(
            "rate_limiter.max_requests",
            self::MAX_REQUESTS,
        );

        if ($attempts >= $maxRequests) {
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
