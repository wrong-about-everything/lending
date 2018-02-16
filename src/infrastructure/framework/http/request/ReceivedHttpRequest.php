<?php

namespace src\infrastructure\framework\http\request;

use \src\infrastructure\framework\http\request\Uri;
use src\useCases\Request;

class ReceivedHttpRequest implements Request
{
    public function method()
    {
        return new HttpMethod($_SERVER['REQUEST_METHOD']);
    }

    public function uri()
    {
        return
            new Uri(
                sprintf(
                    '%s://%s%s',
                    isset($_SERVER['HTTPS']) ? 'https' : 'http',
                    $_SERVER['HTTP_HOST'],
                    $_SERVER['REQUEST_URI']
                )
            );
    }

    public function headers()
    {
        return getallheaders();
    }

    public function body()
    {
        return file_get_contents('php://input');
    }
}
