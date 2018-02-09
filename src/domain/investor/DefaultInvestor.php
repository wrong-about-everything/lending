<?php

namespace src\domain\investor;

use src\domain\investment\Investment;
use src\domain\money\calculation\Difference;
use src\domain\money\calculation\Sum;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\domain\money\Money;
use \Exception;
use \DateTime;

class DefaultInvestor implements Investor
{
    /**
     * @var InvestorId
     */
    private $id;

    /**
     * @var Money
     */
    private $walletAmount;

    /**
     * @var Investment[]
     */
    private $investments;

    public function __construct(InvestorId $id, Money $walletAmount)
    {
        $this->id = $id;
        $this->walletAmount = $walletAmount;
        $this->investments = [];
    }

    public function exists()
    {
        return true;
    }

    public function id()
    {
        return $this->id;
    }

    public function walletAmount()
    {
        return $this->walletAmount;
    }

    public function investments()
    {
        return $this->investments;
    }

    public function hasEnoughMoney(Money $money)
    {
        return $money->isLessOrEqual($this->walletAmount);
    }

    public function invest(Investment $investment)
    {
        if (!$this->hasEnoughMoney($investment->amount())) {
            throw new Exception(
                sprintf(
                    'Investor %d can not invest %s since he has only %s',
                    $this->id->id(),
                    $investment->amount()->display(),
                    $this->walletAmount->display()
                )
            );
        }

        $this->walletAmount = new Difference($this->walletAmount, $investment->amount());
        $this->investments[] = $investment;
    }

    public function calculate(DateTime $start, DateTime $finish)
    {
        return
            array_reduce(
                array_filter(
                    $this->investments,
                    function (Investment $investment) use ($finish) {
                        return $investment->isBefore($finish);
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
