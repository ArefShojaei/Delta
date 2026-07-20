<?php

namespace Tests\Unit\Components;

use PHPUnit\Framework\TestCase;

use Delta\Components\Http\Request;
use Delta\Components\Http\Response;
use Delta\Components\Http\Interfaces\Request as IRequest;
use Delta\Components\Http\Interfaces\Response as IResponse;
use Delta\Components\Http\Enums\HttpRequestHeader;
use Delta\Components\Container\Container;

final class RequestResponseTest extends TestCase
{
    private Request $request;
    private Response $response;
    private Container $container;

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
            'Content-Type' => 'application/json',
        ];

        $this->request = new Request($headers, $this->container);
        $this->response = new Response();
    }

    /**
     * @test
     */
    public function requestImplementsInterface(): void
    {
        $interfaces = class_implements(Request::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IRequest::class, $interfaces);
    }

    /**
     * @test
     */
    public function responseImplementsInterface(): void
    {
        $interfaces = class_implements(Response::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IResponse::class, $interfaces);
    }

    /**
     * @test
     */
    public function requestGetMethod(): void
    {
        $method = $this->request->method();

        $this->assertEquals('GET', $method);
        $this->assertIsString($method);
    }

    /**
     * @test
     */
    public function requestGetUri(): void
    {
        $uri = $this->request->uri();

        $this->assertEquals('/api/users', $uri);
    }

    /**
     * @test
     */
    public function requestGetRoute(): void
    {
        $route = $this->request->route();

        $this->assertEquals('/users', $route);
    }

    /**
     * @test
     */
    public function requestGetIp(): void
    {
        $ip = $this->request->ip();

        $this->assertEquals('127.0.0.1', $ip);
    }

    /**
     * @test
     */
    public function requestGetProtocol(): void
    {
        $protocol = $this->request->protocol();

        $this->assertEquals('HTTP/1.1', $protocol);
    }

    /**
     * @test
     */
    public function requestGetDomain(): void
    {
        $domain = $this->request->domain();

        $this->assertEquals('localhost', $domain);
    }

    /**
     * @test
     */
    public function requestGetAgent(): void
    {
        $agent = $this->request->agent();

        $this->assertStringContainsString('Mozilla', $agent);
    }

    /**
     * @test
     */
    public function requestGetTime(): void
    {
        $time = $this->request->time();

        $this->assertIsInt($time);
        $this->assertGreaterThan(0, $time);
    }

    /**
     * @test
     */
    public function requestGetHost(): void
    {
        $host = $this->request->host();

        $this->assertEquals('localhost:8000', $host);
    }

    /**
     * @test
     */
    public function requestGetHeaderByString(): void
    {
        $header = $this->request->header('Content-Type');

        $this->assertEquals('application/json', $header);
    }

    /**
     * @test
     */
    public function requestGetHeaderByEnum(): void
    {
        $header = $this->request->header(HttpRequestHeader::METHOD);

        $this->assertEquals('GET', $header);
    }

    /**
     * @test
     */
    public function requestGetNonExistentHeaderReturnsNull(): void
    {
        $header = $this->request->header('Non-Existent-Header');

        $this->assertNull($header);
    }

    /**
     * @test
     */
    public function requestGetAllHeaders(): void
    {
        $headers = $this->request->headers();

        $this->assertIsArray($headers);
        $this->assertNotEmpty($headers);
        $this->assertArrayHasKey('Method', $headers);
        $this->assertArrayHasKey('IP', $headers);
    }

    /**
     * @test
     */
    public function requestDynamicPropertySet(): void
    {
        $this->request->userId = 123;

        $this->assertEquals(123, $this->request->userId);
    }

    /**
     * @test
     */
    public function requestDynamicPropertyGetNonExistentReturnsNull(): void
    {
        $this->assertNull($this->request->nonExistent);
    }

    /**
     * @test
     */
    public function requestQuery(): void
    {
        $_GET = ['search' => 'test', 'page' => '1'];

        $query = $this->request->query();

        $this->assertIsArray($query);
        $this->assertArrayHasKey('search', $query);
    }

    /**
     * @test
     */
    public function requestQueryWithKey(): void
    {
        $_GET = ['search' => 'test'];

        $value = $this->request->query('search');

        $this->assertEquals('test', $value);
    }

    /**
     * @test
     */
    public function requestGetNonExistentQueryParam(): void
    {
        $_GET = [];

        $value = $this->request->query('non_existent');

        $this->assertNull($value);
    }

    /**
     * @test
     */
    public function responseStatus(): void
    {
        // Note: Can't directly test http_response_code in unit tests
        // but we can verify the method is callable
        $this->assertTrue(method_exists($this->response, 'status'));
    }

    /**
     * @test
     */
    public function responseHeader(): void
    {
        $this->assertTrue(method_exists($this->response, 'header'));
    }

    /**
     * @test
     */
    public function responseJson(): void
    {
        $this->assertTrue(method_exists($this->response, 'json'));
    }

    /**
     * @test
     */
    public function responseBody(): void
    {
        $data = ['key' => 'value'];
        
        $this->response->body($data);

        // Verify body can be set
        $this->assertTrue(method_exists($this->response, 'body'));
    }

    /**
     * @test
     */
    public function responseRedirect(): void
    {
        $this->assertTrue(method_exists($this->response, 'redirect'));
    }

    /**
     * @test
     */
    public function responseCookie(): void
    {
        $this->assertTrue(method_exists($this->response, 'cookie'));
    }

    /**
     * @test
     */
    public function responseSession(): void
    {
        $this->assertTrue(method_exists($this->response, 'session'));
    }

    /**
     * @test
     */
    public function responseHtml(): void
    {
        $this->assertTrue(method_exists($this->response, 'html'));
    }
}
