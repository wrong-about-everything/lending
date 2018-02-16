<?php

namespace src\infrastructure\framework\http\request;

use Exception;

class HttpMethod
{
    private $method;
    private $availableMethods = ['GET', 'POST', 'HEAD', 'PUT', 'DELETE', 'OPTIONS', 'CONNECT'];

    public function __construct($method)
    {
        if (!in_array($method, $this->availableMethods)) {
            throw new Exception('Unknown http method');
        }

        $this->method = $method;
    }

    public function isEqualTo(HttpMethod $method)
    {
        return $this->value() == $method->value();
    }

    public function value()
    {
        return $this->method;
    }
}