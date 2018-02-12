<?php

namespace src\useCases\investInTranche\response;

use src\useCases\Action;
use src\useCases\Request;
use src\useCases\Response;

class ToXml extends Response
{
    private $origin;

    public function __construct(Action $action)
    {
        $this->origin = $action;
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
        $response = $this->origin->act($request);
        $xml->addChild('investor', $response['investor_id']);

    }
}
