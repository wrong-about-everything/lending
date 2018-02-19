<?php

namespace src\infrastructure\controllers\investInTranche\response\xml;

use src\infrastructure\framework\http\response\code\SuccessCode;
use src\infrastructure\framework\http\response\header\XmlContentType;
use src\useCases\Response;

class InvestedSuccessfully extends Response
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    protected function code()
    {
        return new SuccessCode();
    }

    protected function headers()
    {
        return [new XmlContentType()];
    }

    protected function body()
    {
        return 'JOPA!!';
    }
}
