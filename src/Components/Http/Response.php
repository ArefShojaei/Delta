<?php

namespace Delta\Components\Http;

use Delta\Components\{
    Http\Interfaces\Response as IResponse,
    Cookie\Interfaces\Cookie,
    Session\Session,
    Json\Json,
};


class Response extends HttpStatus implements IResponse
{
    private array $data;


    public function body(array $data): void
    {
        $this->data = $data;
    }

    public function header(string $key, string $value): void
    {
        header("{$key}: {$value}");
    }

    public function redirect(string $route): void
    {
        $this->header("Location", $route);
    }

    public function cookie(string $key, string $value): void
    {
        Cookie::set($key, $value);
    }

    public function session(string $key, string $value): void
    {
        Session::set($key, $value);
    }

    public function status(int|HttpStatus $code): void
    {
        http_response_code($code);
    }

    public function json(array $data): void
    {
        $this->header("Content-type", "application/json");

        $this->body($data);

        $this->send();
    }

    public function html(string $content): void
    {
        $this->header("Content-type", "text/html");

        echo $content;
    }

    /**
     * Send JSON data
     */
    public function send(): void
    {
        echo Json::encode($this->data);
    }
}
