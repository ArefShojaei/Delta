<?php

namespace Tests\Unit\Components;

use ReflectionClass;

use Delta\Components\Container\Container;
use Delta\Components\Http\{Request, Response};
use Delta\Components\Routing\{Router, RouteMeta};
use Delta\Components\Http\Enums\HttpRequestHeader;
use Delta\Components\Json\Exceptions\JsonException;
use Delta\Components\Http\Interfaces\{
    Request as RequestInterface,
    Response as ResponseInterface,
};

use Tests\Fixtures\Http\DemoController;
use Tests\Support\TestCase;

final class RequestResponseTest extends TestCase
{
    private Request $request;
    private Response $response;
    private Container $container;
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new Container();
        $this->router = new Router();
        $this->container->bind(Router::class, fn() => $this->router);

        $this->request = new Request(
            [
                "REQUEST_METHOD" => "GET",
                "REQUEST_URI" => "/api/users/7",
                "PHP_SELF" => "/api/users/7",
                "REMOTE_ADDR" => "127.0.0.1",
                "SERVER_PROTOCOL" => "HTTP/1.1",
                "SERVER_NAME" => "localhost",
                "HTTP_USER_AGENT" => "PHPUnit",
                "REQUEST_TIME" => time(),
                "HTTP_HOST" => "localhost:8000",
                "Content-Type" => "application/json",
            ],
            $this->container,
        );

        $this->response = new Response();
        $this->router->addRoute(
            "GET",
            "/api/users/{id}",
            $this->routeMetaFor("user"),
        );
        $this->router->findRoute("GET", "/api/users/7");
    }

    public function testRequestImplementsInterface(): void
    {
        $interfaces = class_implements(Request::class);

        $this->assertArrayHasKey(RequestInterface::class, $interfaces);
    }

    public function testResponseImplementsInterface(): void
    {
        $interfaces = class_implements(Response::class);

        $this->assertArrayHasKey(ResponseInterface::class, $interfaces);
    }

    public function testRequestHeaderAccessorsWork(): void
    {
        $this->assertSame("GET", $this->request->method());
        $this->assertSame("/api/users/7", $this->request->uri());
        $this->assertSame("/api/users/7", $this->request->route());
        $this->assertSame("127.0.0.1", $this->request->ip());
        $this->assertSame("HTTP/1.1", $this->request->protocol());
        $this->assertSame("localhost", $this->request->domain());
        $this->assertSame("PHPUnit", $this->request->agent());
        $this->assertSame("localhost:8000", $this->request->host());
        $this->assertSame(
            "application/json",
            $this->request->header("Content-Type"),
        );
        $this->assertSame(
            "GET",
            $this->request->header(HttpRequestHeader::METHOD),
        );
    }

    public function testRequestQueryAndBodyAccessorsWork(): void
    {
        $previousGet = $_GET;
        $_GET = ["search" => "delta"];

        try {
            $this->assertSame($_GET, $this->request->query());
            $this->assertSame("delta", $this->request->query("search"));

            $this->expectException(JsonException::class);
            $this->assertIsObject($this->request->body());
            $this->assertNull($this->request->body("missing"));
        } finally {
            $_GET = $previousGet;
        }
    }

    public function testRequestParamsUseBoundRouterState(): void
    {
        $this->assertSame("7", $this->request->params("id"));
        $this->assertSame(["id" => "7"], $this->request->params());
    }

    public function testRequestSupportsDynamicProperties(): void
    {
        $this->request->userId = 123;

        $this->assertSame(123, $this->request->userId);
        $this->assertNull($this->request->unknown);
    }

    public function testResponseBodyAndJsonOutput(): void
    {
        $reflection = new ReflectionClass($this->response);
        $property = $reflection->getProperty("data");
        $property->setAccessible(true);

        $payload = ["ok" => true];

        ob_start();
        $this->response->json($payload);
        $json = ob_get_clean();

        $this->assertSame($payload, $property->getValue($this->response));
        $this->assertSame('{"ok":true}', $json);
    }

    public function testResponseHtmlOutputAndStatus(): void
    {
        ob_start();
        $this->response->status(201);
        $this->response->html("<h1>Delta</h1>");
        $html = ob_get_clean();

        $this->assertSame(201, http_response_code());
        $this->assertSame("<h1>Delta</h1>", $html);
    }

    private function routeMetaFor(string $methodName): RouteMeta
    {
        $reflection = new ReflectionClass(DemoController::class);
        $method = $reflection->getMethod($methodName);

        return new RouteMeta($method, $reflection, []);
    }
}
