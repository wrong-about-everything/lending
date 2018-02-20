<?php

namespace src\infrastructure\framework\fallback;

use src\infrastructure\framework\http\response\Code;
use src\infrastructure\framework\http\response\code\ServiceUnavailable;
use src\useCases\Response;

class SystemFailure extends Response
{
    protected function code(): Code
    {
        return new ServiceUnavailable();
    }

    protected function headers(): array
    {
        return [];
    }

    protected function body(): string
    {
        return '';
    }
}