<?php

namespace src\useCases;

use src\infrastructure\framework\http\request\HttpMethod;
use src\infrastructure\framework\http\request\Uri;

interface Request
{
    /**
     * @return HttpMethod
     */
    public function method();

    /**
     * @return Uri
     */
    public function uri();

    /**
     * @return Header[]
     */
    public function headers();

    /**
     * @return string
     */
    public function body();
}
