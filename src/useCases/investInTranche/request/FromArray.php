<?php

namespace src\useCases\investInTranche\request;

use src\useCases\Request;

class FromArray implements Request
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function data()
    {
        return $this->data;
    }
}