<?php

namespace src\infrastructure\framework\fallback;

use src\infrastructure\framework\http\response\code\ServiceUnavailable;
use src\useCases\Response;

class SystemFailure extends Response
{
    protected function code()
    {
        return new ServiceUnavailable();
    }

    protected function headers()
    {
        return [];
    }

    protected function body()
    {
        return '';
    }
}