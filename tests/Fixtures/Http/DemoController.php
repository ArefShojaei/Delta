<?php

namespace Tests\Fixtures\Http;

use Delta\Components\Routing\Attributes\Get;
use Delta\Components\Http\{Request, Response};
use Delta\Components\Layer\Attributes\Controller;

#[Controller(prefix: "/api", name: "demo")]
final class DemoController
{
    #[Get(path: "/users", name: "users")]
    public function users(Request $request, Response $response): void
    {
        $response->json([
            "route" => $request->route(),
            "method" => $request->method(),
        ]);
    }

    #[Get(path: "/users/{id}", name: "user")]
    public function user(Request $request, Response $response): void
    {
        $response->json([
            "id" => $request->params("id"),
        ]);
    }
}
