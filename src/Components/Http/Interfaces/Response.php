<?php

namespace Delta\Components\Http;


interface Response
{
    public function setBody(array $body): void;

    public function getBody(): array;
    
    public function send(): void;
}
