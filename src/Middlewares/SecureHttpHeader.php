<?php

namespace Delta\Middlewares;

use Closure;
use Delta\Common\Interfaces\Middleware as IMiddleware;
use Delta\Components\Http\Request;
use Delta\Components\Http\Response;


final class SecureHttpHeader implements IMiddleware
{
    public function handle(Request $request, Response $response, Closure $next): bool
    {
        $response->header("Permissions-Policy", "geolocation=(), microphone=()");
        $response->header("Referrer-Policy", "strict-origin-when-cross-origin");
        $response->header("Content-Type", "application/json; charset=utf-8");
        $response->header("Cache-Control", "no-store, no-cache, private");
        $response->header("X-Permitted-Cross-Domain-Policies", "none");
        $response->header("X-Powered-By", "Delta - PHP Framework");
        $response->header("X-Content-Type-Options", "nosniff");
        $response->header("Content-Security-Policy", "DENY");
        $response->header("Referrer-Policy", "no-referrer");
        $response->header("Server", "nginx");

        return $next();
    }
}
