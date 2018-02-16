<?php

namespace src\infrastructure\framework\http\request;

use \Exception;

class Uri
{
    private $uri;

    public function __construct($uri)
    {
        if (
            !preg_match(
                '@(https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?$@iS',
                $uri
            )
        ) {
            throw new Exception('Uri is invalid');
        }

        $this->uri = $uri;
    }

    public function value()
    {
        return $this->uri;
    }
}