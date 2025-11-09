<?php

namespace Delta\Middlewares;

use Closure;
use Delta\Common\Interfaces\Middleware as IMiddleware;
use Delta\Components\Http\Request;
use Delta\Components\Http\Response;


final class CORS implements IMiddleware
{
    public function handle(Request $request, Response $response, Closure $next): bool
    {
        $response->header("Access-Control-Allow-Origin", "*");
        $response->header("Access-Control-Allow-Methods", "GET, POST, PUT, PATCH, DELETE");
        $response->header("Access-Control-Allow-Headers", "Content-Type, Authorization");

        return $next();
    }
}
