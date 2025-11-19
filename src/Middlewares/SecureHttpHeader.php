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
        $response->header("X-Frame-Options", "DENY");
        $response->header("Strict-Transport-Security", "max-age=63072000; includeSubDomains; preload");
        $response->header("Referrer-Policy", "camera=(), microphone=(), geolocation=(), payment=(), fullscreen=(self)");
        $response->header("Cross-Origin-Opener-Policy", "same-origin");
        $response->header("Cross-Origin-Embedder-Policy", "require-corp");
        $response->header("Cross-Origin-Resource-Policy", "same-origin");
        $response->header("X-XSS-Protection", "0");
        $response->header("Pragma", "no-cache");
        $response->header("Expires", "0");
        $response->header(
            "Content-Security-Policy",
            "default-src 'self'; " .
                "script-src 'self' 'unsafe-inline' https:; " .
                "style-src 'self' 'unsafe-inline' https: 'unsafe-inline'; " .
                "img-src 'self' data: https:; " .
                "font-src 'self' https:; " .
                "connect-src 'self' https:; " .
                "frame-ancestors 'none'; " .
                "upgrade-insecure-requests; " .
                "block-all-mixed-content"
        );
        
        return $next();
    }
}
