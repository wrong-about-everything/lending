<?php

namespace src\infrastructure\framework\routing;

use src\infrastructure\framework\http\response\Body;
use src\infrastructure\framework\http\response\Code;
use src\infrastructure\framework\http\response\code\NotFound;
use src\infrastructure\framework\http\response\Header;
use src\useCases\Response;

class ResourceNotFoundResponse extends Response
{
    protected function code(): Code
    {
        return new NotFound();
    }

    /**
     * @return Header[]
     */
    protected function headers(): array
    {
        return [];
    }

    /**
     * @return Body
     */
    protected function body(): string
    {
        return '';
    }
}