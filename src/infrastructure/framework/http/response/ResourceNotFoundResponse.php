<?php

namespace src\infrastructure\framework\http\response;

use src\infrastructure\framework\http\response\code\NotFound;
use src\useCases\Response;

class ResourceNotFoundResponse extends Response
{
    protected function code()
    {
        return new NotFound();
    }

    /**
     * @return Header[]
     */
    protected function headers()
    {
        return [];
    }

    /**
     * @return Body
     */
    protected function body()
    {
        return '';
    }
}