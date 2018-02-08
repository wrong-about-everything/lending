<?php

namespace src\domain\investment;

use src\domain\investor\InvestorId;
use \DateTime;
use src\domain\money\format\InMinorUnits;
use src\domain\money\Money;
use src\domain\percentage\Percentage;
use \Exception;

class FixedInterestPercentageInvestment implements Investment
{
    /**
     * @var InvestmentId
     */
    private $id;

    /**
     * @var InvestorId
     */
    private $investorId;

    /**
     * @var DateTime
     */
    private $madeAt;

    /**
     * @var Percentage
     */
    private $rate;

    /**
     * @var Money
     */
    private $amount;

    public function __construct(
        InvestmentId $investmentId,
        InvestorId $investorId,
        DateTime $madeAt,
        Percentage $rate,
        Money $amount
    )
    {
        $this->id = $investmentId;
        $this->investorId = $investorId;
        $this->madeAt = $madeAt;
        $this->rate = $rate;
        $this->amount = $amount;
    }

    public function id()
    {
        return $this->id;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function belongsTo(InvestorId $investorId)
    {
        return $this->investorId->equals($investorId);
    }

    public function isBefore(DateTime $finish)
    {
        return $this->madeAt < $finish;
    }

    public function calculateFor(DateTime $start, DateTime $finish)
    {
        if (!$this->isBefore($finish)) {
            throw new Exception('Finish date should be greater than the date when investment was made');
        }

        return
            new InMinorUnits(
                round(
                    (((int) $finish->diff(max($start, $this->madeAt))->format('%a') + 1) / ((int) $finish->diff($start)->format('%a') + 1))
                    *
                    $this->amount->amount() * $this->rate->value()
                ),
                $this->amount->currency()
            )
;
    }
}