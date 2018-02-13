<?php

namespace src\infrastructure\controllers\investInTranche\response;

use src\useCases\Action;
use src\useCases\Request;
use src\useCases\Response;

class ToXml extends Response
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
        $xml = new SimpleXMLElement('<xml/>');
        $response = $this->data;
        $xml->addChild('investor', $response['investor_id']);

        return WithBody($xml);
    }
}
