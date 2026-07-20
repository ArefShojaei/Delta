<?php

namespace Tests\Unit\Components;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

use Delta\Components\Routing\Router;
use Delta\Components\Routing\Route;
use Delta\Components\Routing\RouteMeta;
use Delta\Components\Routing\Interfaces\Router as IRouter;
use Delta\Components\Routing\Exceptions\RouteNotFound;
use Delta\Components\Http\Exceptions\InvalidHttpRequestMethod;
use Delta\Components\Container\Container;

final class RouterTest extends TestCase
{
    private Router $router;
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
        $this->container = new Container();
    }

    /**
     * @test
     */
    public function implementsRouterInterface(): void
    {
        $interfaces = class_implements(Router::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IRouter::class, $interfaces);
    }

    /**
     * @test
     */
    public function addRouteToRouter(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users', $meta);

        $routes = $this->router->getRoutes('GET');

        $this->assertArrayHasKey('/users', $routes);
        $this->assertInstanceOf(Route::class, $routes['/users']);
    }

    /**
     * @test
     */
    public function addMultipleRoutesWithSameMethod(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users', $meta);
        $this->router->addRoute('GET', '/posts', $meta);

        $routes = $this->router->getRoutes('GET');

        $this->assertCount(2, $routes);
        $this->assertArrayHasKey('/users', $routes);
        $this->assertArrayHasKey('/posts', $routes);
    }

    /**
     * @test
     */
    public function addRoutesWithDifferentMethods(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users', $meta);
        $this->router->addRoute('POST', '/users', $meta);
        $this->router->addRoute('DELETE', '/users/1', $meta);

        $allRoutes = $this->router->getRoutes();

        $this->assertArrayHasKey('GET', $allRoutes);
        $this->assertArrayHasKey('POST', $allRoutes);
        $this->assertArrayHasKey('DELETE', $allRoutes);
    }

    /**
     * @test
     */
    public function matchExactRoute(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users', $meta);

        $route = $this->router->findRoute('GET', '/users');

        $this->assertInstanceOf(Route::class, $route);
        $this->assertEquals('/users', $route->path);
    }

    /**
     * @test
     */
    public function matchRouteWithDynamicParameter(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users/{id}', $meta);

        $route = $this->router->findRoute('GET', '/users/123');

        $this->assertInstanceOf(Route::class, $route);
        $this->assertEquals('/users/{id}', $route->path);
    }

    /**
     * @test
     */
    public function extractRouteParameterFromUri(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users/{id}', $meta);

        $this->router->findRoute('GET', '/users/42');
        $params = $this->router->getRouteParams();

        $this->assertArrayHasKey('id', $params);
        $this->assertEquals('42', $params['id']);
    }

    /**
     * @test
     */
    public function extractMultipleRouteParameters(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users/{userId}/posts/{postId}', $meta);

        $this->router->findRoute('GET', '/users/5/posts/10');
        $params = $this->router->getRouteParams();

        $this->assertArrayHasKey('userId', $params);
        $this->assertArrayHasKey('postId', $params);
        $this->assertEquals('5', $params['userId']);
        $this->assertEquals('10', $params['postId']);
    }

    /**
     * @test
     */
    public function throwExceptionForInvalidHttpMethod(): void
    {
        $this->expectException(InvalidHttpRequestMethod::class);

        $this->router->findRoute('INVALID_METHOD', '/users');
    }

    /**
     * @test
     */
    public function matchFirstMatchingRoute(): void
    {
        $meta1 = $this->createMockRouteMeta();
        $meta2 = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users', $meta1);
        $this->router->addRoute('GET', '/users', $meta2);

        $route = $this->router->findRoute('GET', '/users');

        $this->assertInstanceOf(Route::class, $route);
    }

    /**
     * @test
     */
    public function addRouteWithMiddlewares(): void
    {
        $meta = $this->createMockRouteMeta();
        $middlewares = ['Middleware1', 'Middleware2'];
        
        $this->router->addRoute('POST', '/users', $meta, $middlewares);

        $routes = $this->router->getRoutes('POST');
        $route = $routes['/users'];

        $this->assertCount(2, $route->middlewares);
        $this->assertContains('Middleware1', $route->middlewares);
        $this->assertContains('Middleware2', $route->middlewares);
    }

    /**
     * @test
     */
    public function getRoutesWithoutMethodReturnsAllRoutes(): void
    {
        $meta = $this->createMockRouteMeta();
        
        $this->router->addRoute('GET', '/users', $meta);
        $this->router->addRoute('POST', '/users', $meta);

        $allRoutes = $this->router->getRoutes();

        $this->assertIsArray($allRoutes);
        $this->assertArrayHasKey('GET', $allRoutes);
        $this->assertArrayHasKey('POST', $allRoutes);
    }

    /**
     * Helper method to create mock RouteMeta
     */
    private function createMockRouteMeta(): RouteMeta
    {
        $reflection = new ReflectionClass(RouterTest::class);
        $method = $reflection->getMethod('createMockRouteMeta');

        return new RouteMeta(
            RouterTest::class,
            'createMockRouteMeta',
            [],
            $reflection,
            $method
        );
    }
}
