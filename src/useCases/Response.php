<?php

namespace src\useCases;

use src\infrastructure\framework\http\response\Code;
use src\infrastructure\framework\http\response\Header;

abstract class Response
{
    abstract protected function code(): Code;

    /**
     * @return Header[]
     */
    abstract protected function headers(): array;

    /**
     * @return Body
     */
    abstract protected function body(): string;

    final public function isResourceFound(): bool
    {
        return !$this->code()->isNotFound();
    }

    final public function display()
    {
        http_response_code($this->code()->value());

        array_walk(
            $this->headers(),
            function (Header $header) {
                header($header->value());
            }
        );

        echo $this->body();

        die();
    }
}
