<?php

namespace Tests\Unit\Components;

use ReflectionClass;

use Delta\Components\Container\Container;
use Delta\Components\Http\{Request, Response};
use Delta\Components\Http\Exceptions\InternalServerError;
use Delta\Components\Routing\Attributes\NotFound;
use Delta\Components\Routing\Exceptions\RouteNotFound;
use Delta\Components\Http\Exceptions\InvalidHttpRequestMethod;
use Delta\Components\Routing\Interfaces\Router as RouterInterface;
use Delta\Components\Routing\{Router, Route, RouteAlias, RouteMeta};

use Tests\Fixtures\Http\DemoController;
use Tests\Support\TestCase;

final class RouterTest extends TestCase
{
    private Router $router;
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
        $this->container = new Container();
        $this->resetStaticProperty(RouteAlias::class, "names", []);
    }

    public function testImplementsRouterInterface(): void
    {
        $interfaces = class_implements(Router::class);

        $this->assertArrayHasKey(RouterInterface::class, $interfaces);
    }

    public function testAddAndReadRoutes(): void
    {
        $routeMeta = $this->routeMetaFor("users");
        $this->router->addRoute("GET", "/api/users", $routeMeta, [
            "middleware",
        ]);

        $routes = $this->router->getRoutes("GET");

        $this->assertArrayHasKey("/api/users", $routes);
        $this->assertInstanceOf(Route::class, $routes["/api/users"]);
        $this->assertSame(["middleware"], $routes["/api/users"]->middlewares);
    }

    public function testFindRouteMatchesDynamicParameters(): void
    {
        $this->router->addRoute(
            "GET",
            "/api/users/{id}",
            $this->routeMetaFor("user"),
        );

        $route = $this->router->findRoute("GET", "/api/users/42");

        $this->assertSame("/api/users/{id}", $route->path);
        $this->assertSame(["id" => "42"], $this->router->getRouteParams());
    }

    public function testFindRouteFallsBackToNotFoundRoute(): void
    {
        $this->router->addRoute(
            "GET",
            NotFound::PATH,
            $this->routeMetaFor("users"),
        );

        $route = $this->router->findRoute("GET", "/missing");

        $this->assertSame(NotFound::PATH, $route->path);
    }

    public function testFindRouteThrowsForInvalidMethod(): void
    {
        $this->expectException(InvalidHttpRequestMethod::class);

        $this->router->findRoute("INVALID", "/api/users");
    }

    public function testFindRouteThrowsWhenFallbackRouteIsMissing(): void
    {
        $this->expectException(InvalidHttpRequestMethod::class);

        $this->router->findRoute("GET", "/missing");
    }

    private function routeMetaFor(string $methodName): RouteMeta
    {
        $reflection = new ReflectionClass(DemoController::class);
        $method = $reflection->getMethod($methodName);

        return new RouteMeta($method, $reflection, []);
    }
}
