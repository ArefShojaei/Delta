<?php

namespace Tests\Unit;

use Delta\Components\Config\Config;
use Delta\Components\Container\Container;
use Delta\Components\Http\{HttpStatus, Request, Response};
use Delta\Middlewares\{CORS, RateLimiter, SecureHttpHeader};

use Tests\Support\TestCase;

final class MiddlewaresTest extends TestCase
{
    private Container $container;
    private Response $response;
    private string $cachePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetStaticProperty(Config::class, "data", []);
        $this->container = new Container();
        $this->response = new Response();
        $this->cachePath = $this->tempDir("delta-cache-");

        Config::set([
            "storage" => [
                "cache" => ["path" => $this->cachePath],
            ],
            "rate_limiter" => [
                "max_requests" => 1,
                "decay_seconds" => 60,
            ],
        ]);
    }

    public function testCorsStopsPreflightRequests(): void
    {
        $request = $this->makeRequest("OPTIONS", "/api/users");
        $middleware = new CORS();

        $this->assertFalse(
            $middleware->handle($request, $this->response, fn() => true),
        );
        $this->assertSame(HttpStatus::HTTP_NO_CONTENT, http_response_code());
    }

    public function testCorsAllowsRegularRequests(): void
    {
        $request = $this->makeRequest("GET", "/api/users", [
            "Origin" => "https://example.test",
        ]);
        $middleware = new CORS();

        $this->assertTrue(
            $middleware->handle($request, $this->response, fn() => true),
        );
    }

    public function testSecureHeadersMiddlewarePassesThrough(): void
    {
        $request = $this->makeRequest("GET", "/api/users");
        $middleware = new SecureHttpHeader();

        $called = false;

        $result = $middleware->handle(
            $request,
            $this->response,
            function () use (&$called) {
                $called = true;

                return true;
            },
        );

        $this->assertTrue($result);
        $this->assertTrue($called);
    }

    public function testRateLimiterAllowsFirstRequestAndBlocksTheSecond(): void
    {
        $request = $this->makeRequest("GET", "/api/users", [
            "REMOTE_ADDR" => "10.0.0.1",
        ]);
        $middleware = new RateLimiter();

        $this->assertTrue(
            $middleware->handle($request, $this->response, fn() => true),
        );
        $this->assertFalse(
            $middleware->handle($request, $this->response, fn() => true),
        );
    }

    private function makeRequest(
        string $method,
        string $route,
        array $overrides = [],
    ): Request {
        $headers = array_merge(
            [
                "REQUEST_METHOD" => $method,
                "REQUEST_URI" => $route,
                "PHP_SELF" => $route,
                "REMOTE_ADDR" => "127.0.0.1",
                "SERVER_PROTOCOL" => "HTTP/1.1",
                "SERVER_NAME" => "localhost",
                "HTTP_USER_AGENT" => "PHPUnit",
                "REQUEST_TIME" => time(),
                "HTTP_HOST" => "localhost:8000",
                "Origin" => "https://example.test",
            ],
            $overrides,
        );

        return new Request($headers, $this->container);
    }
}
