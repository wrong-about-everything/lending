<?php

namespace src\domain\investor;

class InvestorId
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }

    public function equals(InvestorId $investorId)
    {
        return $this->id === $investorId->id();
    }
}