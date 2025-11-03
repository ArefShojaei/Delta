<?php

namespace Delta\Components\Http;

use Delta\Components\Http\Response as IResponse;
use Delta\Components\Json\Json;
use Delta\Components\Cookie\Interfaces\Cookie;
use Delta\Components\Session\Session;


final class Response extends HttpStatus implements IResponse
{
    private array $data = [];


    public function body(array $body): void
    {
        $this->data = $body;
    }

    public function header(string $key, string $value): void
    {
        header("{$key}: {$value}");
    }

    public function cookie(string $key, string $value): void
    {
        Cookie::set($key, $value);
    }

    public function session(string $key, string $value): void
    {
        Session::set($key, $value);
    }

    public function status($code): void
    {
        http_response_code($code);
    }
    
    public function send(): void
    {
        echo Json::encode($this->data);
    }
}
