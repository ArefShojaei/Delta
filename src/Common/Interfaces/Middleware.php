<?php

namespace Delta\Common\Interfaces;

use Closure;
use Delta\Components\Http\{Request, Response};


interface Middleware
{
    public function handle(
        Request $request,
        Response $response,
        Closure $next,
    ): bool;
}
