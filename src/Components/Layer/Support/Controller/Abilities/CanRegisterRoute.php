<?php

namespace Delta\Components\Layer\Support\Controller\Abilities;

use Delta\Components\Routing\Router;

trait CanRegisterRoute
{
    private function registerRoutes(string $prefix, array $routes): void
    {
        if (empty($routes)) return;

        $router = $this->container->resolve(Router::class);

        foreach ($routes as $method => $meta) {
            foreach ($meta as $route => $data) {
                $router->addRoute(
                    method: $method,
                    path: $prefix . $route,
                    meta: $data["meta"],
                    middlewares: $data["middlewares"],
                );
            }
        }
    }
}
