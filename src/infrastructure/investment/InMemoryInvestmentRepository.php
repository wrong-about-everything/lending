<?php

namespace src\infrastructure\investment;

use DateTime;
use src\domain\investment\Investment;
use src\domain\investment\InvestmentId;
use src\domain\investment\InvestmentRepository;
use src\domain\investor\InvestorId;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\domain\money\Money;
use src\domain\money\calculation\Sum;

class InMemoryInvestmentRepository implements InvestmentRepository
{
    /**
     * @var Investment[]
     */
    private $investments;

    public function __construct()
    {
        $this->investments = [];
    }

    public function calculate(InvestorId $investorId, DateTime $start, DateTime $finish)
    {
        return
            array_reduce(
                array_filter(
                    $this->investments,
                    function (Investment $investment) use ($investorId, $finish) {
                        return $investment->belongsTo($investorId) && $investment->isBefore($finish); // should loan be still open?
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

    public function add(Investment $investment)
    {
        $this->investments[$investment->id()->id()] = $investment;
    }

    public function all()
    {
        return $this->investments;
    }

    /**
     * @return InvestmentId
     */
    public function generateId()
    {
        return new InvestmentId(mt_rand(1, 999999));
    }
}