<?php

namespace src\infrastructure\framework\http\response\code;

use src\infrastructure\framework\http\response\Code;

class NotFound extends Code
{
    public function __construct($code)
    {
        parent::__construct(404);
    }
}