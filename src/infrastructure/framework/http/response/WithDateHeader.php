<?php

namespace src\infrastructure\framework\http\response;

use src\useCases\Response;
use \DateTime;

class WithDateHeader extends Response
{
    private $response;
    private $datetime;

    public function __construct(Response $response, DateTime $datetime)
    {
        $this->response = $response;
        $this->datetime = $datetime;
    }

    protected function code()
    {
        return $this->response->code();
    }

    protected function headers()
    {
        return array_merge([new DateHeader($this->datetime)], $this->headers());
    }

    protected function body()
    {
        return $this->body();
    }

}
