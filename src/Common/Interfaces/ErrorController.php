<?php

namespace Delta\Common\Interfaces;

use Delta\Components\Http\{ Request, Response };
use Delta\Components\Routing\Attributes\{
    NotFound,
    ServerError,
    MethodNotAllowed,
};


interface ErrorController
{
    #[NotFound]
    public function notFound(Request $request, Response $response);

    #[ServerError]
    public function internalServerError(Request $request, Response $response);

    #[MethodNotAllowed]
    public function methodNotAllowed(Request $request, Response $response);
}
