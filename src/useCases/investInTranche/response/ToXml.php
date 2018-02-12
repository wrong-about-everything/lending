<?php

namespace src\useCases\investInTranche\response;

use src\useCases\Action;
use src\useCases\Request;

class ToXml implements Response
{
    private $origin;

    public function __construct(Action $action)
    {
        $this->origin = $action;
    }

    public function display(Request $request)
    {
        $xml = new SimpleXMLElement('<xml/>');
        $response = $this->origin->act($request);
        $xml->addChild('investor', $response['investor_id']);

        echo $xml;
    }
}
