<?php

namespace src\infrastructure\investor;

use src\domain\investor\Investor;
use src\domain\investor\InvestorId;
use src\domain\investor\InvestorRepository;
use src\domain\investor\NonExistentInvestor;
use \DateTime;

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

    public function calculate(InvestorId $investorId, DateTime $start, DateTime $finish)
    {
        return
            array_reduce(
                array_filter(
                    $this->investments,
                    function (Investment $investment) use ($investorId, $finish) {
                        return $investment->belongsTo($investorId) && $investment->isBefore($finish);
                    }
                ),
                function (Money $total, Investment $current) use ($start, $finish) {
                    return
                        new Sum(
                            $total,
                            $current->calculateFor($start, $finish)
                        );
                },
                new InMinorUnits(0, new Pound())
            );
    }
}
