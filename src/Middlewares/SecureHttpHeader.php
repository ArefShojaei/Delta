<?php

namespace Delta\Middlewares;

use Closure;

use Delta\Common\Interfaces\Middleware as IMiddleware;
use Delta\Components\Http\{Request, Response};

final class SecureHttpHeader implements IMiddleware
{
    public function handle(
        Request $request,
        Response $response,
        Closure $next,
    ): bool {
        # === Security Headers ===
        $response->header("X-Content-Type-Options", "nosniff");
        $response->header("X-Frame-Options", "DENY");
        $response->header("X-XSS-Protection", "1; mode=block");
        $response->header("Referrer-Policy", "strict-origin-when-cross-origin");
        $response->header(
            "Permissions-Policy",
            "geolocation=(), microphone=(), camera=(), payment=()",
        );

        # === Content Security Policy ===
        $response->header(
            "Content-Security-Policy",
            "default-src 'self'; " .
                "script-src 'self' 'unsafe-inline' https:; " .
                "style-src 'self' 'unsafe-inline' https:; " .
                "img-src 'self' data: https:; " .
                "font-src 'self' https:; " .
                "connect-src 'self' https:; " .
                "frame-ancestors 'none'; " .
                "base-uri 'self'; " .
                "form-action 'self';",
        );

        # === Remove Information Disclosure ===
        $response->header("Server", "");
        $response->header("X-Powered-By", "Delta Framework");

        return $next();
    }
}
