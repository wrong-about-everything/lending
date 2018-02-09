<?php

namespace src\infrastructure\investor;

use src\domain\investor\Investor;
use src\domain\investor\InvestorId;
use src\domain\investor\InvestorRepository;
use src\domain\investor\NonExistentInvestor;

class InMemoryInvestorRepository implements InvestorRepository
{
    private $investors;

    public function __construct()
    {
        $this->investors = [];
    }

    public function byId(InvestorId $investorId)
    {
        if (!isset($this->investors[$investorId->id()])) {
            return new NonExistentInvestor();
        }

        return $this->investors[$investorId->id()];
    }

    public function add(Investor $investor)
    {
        $this->investors[$investor->id()->id()] = $investor;
    }
}
