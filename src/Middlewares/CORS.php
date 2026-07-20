<?php

namespace Delta\Middlewares;

use Closure;

use Delta\Common\Interfaces\Middleware as IMiddleware;
use Delta\Components\Http\{Request, Response};

final class CORS implements IMiddleware
{
    public function handle(
        Request $request,
        Response $response,
        Closure $next,
    ): bool {
        $origin = $request->header("Origin") ?? "*";

        $response->header("Access-Control-Allow-Origin", $origin);

        if ($origin !== "*") {
            $response->header("Access-Control-Allow-Credentials", "true");
        }

        $response->header(
            "Access-Control-Allow-Methods",
            "GET, POST, PUT, PATCH, DELETE",
        );

        $response->header(
            "Access-Control-Allow-Headers",
            "Content-Type, Authorization, X-Requested-With, Accept",
        );

        $response->header("Access-Control-Max-Age", "86400");

        # Preflight Request
        if ($request->method() === "OPTIONS") {
            $response->status(204);

            return false;
        }

        return $next();
    }
}
