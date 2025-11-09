<?php

namespace Delta\Components\Http;

use Exception;
use Delta\Components\Http\Interfaces\Http as IHttp;
use Delta\Components\Http\Exceptions\{
    InvalidHttpRequestMethod,
    InternalServerError,
};
use Delta\Components\Routing\{Exceptions\RouteNotFound, Router};


final class Http implements IHttp
{
    public function __construct(
        private Request $request,
        private Response $response,
        private Router $router,
    ) {}

    public function listen(): void
    {
        try {
            $route = $this->router->findRoute(
                $this->request->method(),
                $this->request->route(),
            );

            $this->applyMiddlewares($route->middlewares);

            $this->router->dispatch($route, [$this->request, $this->response]);
        } catch (InvalidHttpRequestMethod $error) {
            $this->sendFailedResponseError($error);
        } catch (RouteNotFound $error) {
            $this->sendFailedResponseError($error);
        } catch (InternalServerError $error) {
            $this->sendFailedResponseError($error);
        } catch (InternalServerError $error) {
            $this->sendFailedResponseError($error);
        }
    }

    public function applyMiddlewares(array $middlewares): void
    {
        $next = fn() => true;

        foreach ($middlewares as $middleware) {
            $isOpenedNext = (new $middleware)->handle($this->request, $this->response, $next);

            if (is_null($isOpenedNext)) throw new InternalServerError();

            if (!$isOpenedNext) break;
        }

        if (!$isOpenedNext) exit;
    }

    private function sendFailedResponseError(Exception $error): void
    {
        $this->response->status($error->getCode());

        $this->response->json([
            "code" => $error->getCode(),
            "message" => $error->getMessage(),
        ]);

        exit;
    }
}
