<?php

namespace src\infrastructure\framework\http\request;

use src\useCases\Request;

class HttpRequestStub implements Request
{
    private $method;
    private $uri;
    private $headers;
    private $body;

    public function __construct(HttpMethod $method, Uri $uri, array $headers, $body)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function method(): HttpMethod
    {
        return $this->method;
    }

    public function uri(): Uri
    {
        return $this->uri;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function body(): string
    {
        return $this->body;
    }
}
