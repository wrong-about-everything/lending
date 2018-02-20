<?php

namespace src\useCases;

use src\infrastructure\framework\http\request\HttpMethod;
use src\infrastructure\framework\http\request\Uri;

interface Request
{
    public function method(): HttpMethod;

    public function uri(): Uri;

    /**
     * @return Header[]
     */
    public function headers(): array;

    public function body(): string;
}
