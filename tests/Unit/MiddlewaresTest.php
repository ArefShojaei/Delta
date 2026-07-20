<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Closure;

use Delta\Middlewares\CORS;
use Delta\Middlewares\SecureHttpHeader;
use Delta\Common\Interfaces\Middleware;
use Delta\Components\Http\Request;
use Delta\Components\Http\Response;
use Delta\Components\Container\Container;

final class MiddlewaresTest extends TestCase
{
    private Container $container;
    private Request $request;
    private Response $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
        
        $headers = [
            'Method' => 'GET',
            'URI' => '/api/users',
            'Route' => '/users',
            'IP' => '127.0.0.1',
            'Protocol' => 'HTTP/1.1',
            'Domain' => 'localhost',
            'Agent' => 'Mozilla/5.0',
            'Time' => time(),
            'Host' => 'localhost:8000',
        ];

        $this->request = new Request($headers, $this->container);
        $this->response = new Response();
    }

    /**
     * @test
     */
    public function corsMiddlewareImplementsInterface(): void
    {
        $interfaces = class_implements(CORS::class);

        $this->assertIsArray($interfaces);
        $this->assertArrayHasKey(Middleware::class, $interfaces);
    }

    /**
     * @test
     */
    public function secureHeadersMiddlewareImplementsInterface(): void
    {
        $interfaces = class_implements(SecureHttpHeader::class);

        $this->assertIsArray($interfaces);
        $this->assertArrayHasKey(Middleware::class, $interfaces);
    }

    /**
     * @test
     */
    public function corsMiddlewareHasHandleMethod(): void
    {
        $cors = new CORS();

        $this->assertTrue(method_exists($cors, 'handle'));
    }

    /**
     * @test
     */
    public function secureHeadersMiddlewareHasHandleMethod(): void
    {
        $secure = new SecureHttpHeader();

        $this->assertTrue(method_exists($secure, 'handle'));
    }

    /**
     * @test
     */
    public function corsMiddlewareCallsNextWhenNotOptions(): void
    {
        $cors = new CORS();
        $nextCalled = false;

        $next = function() use (&$nextCalled) {
            $nextCalled = true;
            return true;
        };

        $result = $cors->handle($this->request, $this->response, $next);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function corsMiddlewareReturnsCorrectlyForOptions(): void
    {
        $cors = new CORS();
        
        $headers = [
            'Method' => 'OPTIONS',
            'URI' => '/api/users',
            'Route' => '/users',
            'IP' => '127.0.0.1',
            'Protocol' => 'HTTP/1.1',
            'Domain' => 'localhost',
            'Agent' => 'Mozilla/5.0',
            'Time' => time(),
            'Host' => 'localhost:8000',
        ];

        $request = new Request($headers, $this->container);
        $response = new Response();

        $next = function() {
            return true;
        };

        $result = $cors->handle($request, $response, $next);

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function secureHeadersMiddlewareReturnsTrue(): void
    {
        $secure = new SecureHttpHeader();
        
        $nextCalled = false;

        $next = function() use (&$nextCalled) {
            $nextCalled = true;
            return true;
        };

        $result = $secure->handle($this->request, $this->response, $next);

        $this->assertTrue($result);
        $this->assertTrue($nextCalled);
    }

    /**
     * @test
     */
    public function corsMiddlewareCallsNextWithClosure(): void
    {
        $cors = new CORS();
        $closureCalled = false;

        $closure = function() use (&$closureCalled) {
            $closureCalled = true;
            return true;
        };

        $cors->handle($this->request, $this->response, $closure);

        $this->assertTrue($closureCalled);
    }
}
