<?php

namespace src\useCases;

abstract class Response
{
    /**
     * @var Response
     */
    private $origin;

    public function __construct(Response $response)
    {
        $this->origin = $response;
    }

    /**
     * @return Code
     */
    abstract protected function code();

    /**
     * @return Header[]
     */
    abstract protected function headers();

    /**
     * @return Body
     */
    abstract protected function body();

    final public function display()
    {
        http_response_code($this->code()->value());

        array_walk(
            $this->headers(),
            function (Header $header) {
                header($header->value());
            }
        );

        echo $this->body()->value();
    }
}
