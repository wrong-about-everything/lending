<?php

namespace src\useCases\investInTranche\request;

use src\useCases\Request;

class FromJson implements Request
{
    private $jsonString;

    public function __construct($jsonString)
    {
        $this->jsonString = $jsonString;
    }

    public function data()
    {
        if (is_null($data = json_decode($this->jsonString, true))) {
            return [];
        }

        return $data;
    }
}