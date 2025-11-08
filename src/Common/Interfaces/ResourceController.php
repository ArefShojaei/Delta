<?php

namespace Delta\Common\Interfaces;

use Delta\Components\Http\{ Request, Response };
use Delta\Components\Routing\Attributes\{ Get, Post, Put, Patch, Delete };


interface ResourceController
{
    #[Get]
    public function index(Request $request, Response $response);

    #[Post]
    public function store(Request $request, Response $response);

    #[Get("/{id}")]
    public function show(Request $request, Response $response);

    #[Put("/{id}"), Patch("/{id}")]
    public function update(Request $request, Response $response);

    #[Delete("/{id}")]
    public function destroy(Request $request, Response $response);
}
