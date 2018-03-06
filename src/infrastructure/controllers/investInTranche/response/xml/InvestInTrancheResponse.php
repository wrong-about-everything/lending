<?php

namespace src\infrastructure\controllers\investInTranche\response\xml;

use src\infrastructure\framework\http\response\Code;
use src\infrastructure\framework\http\response\code\SuccessCode;
use src\infrastructure\framework\http\response\header\XmlContentType;
use src\useCases\Response;

class InvestInTrancheResponse extends Response
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    protected function code(): Code
    {
        return new SuccessCode();
    }

    protected function headers(): array
    {
        return [new XmlContentType()];
    }

    protected function body(): string
    {
        if (isset($this->data[0])) {
            $message = ' message="' . $this->data[0] . '" ';
        } else {
            $message = null;
        }

        return '<response code="' . $this->data['code'] . '"' . ($message ?? '') . '></response>';
    }
}
