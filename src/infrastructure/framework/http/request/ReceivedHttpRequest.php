<?php

namespace src\infrastructure\framework\http\request;

use src\useCases\Request;

class ReceivedHttpRequest implements Request
{
    public function method(): HttpMethod
    {
        return new HttpMethod($_SERVER['REQUEST_METHOD']);
    }

    public function uri(): Uri
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

    public function headers(): array
    {
        return getallheaders();
    }

    public function body(): string
    {
        return file_get_contents('php://input');
    }
}
