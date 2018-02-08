<?php

namespace src\domain\investor;

use src\domain\investment\Investment;
use src\domain\money\calculation\Difference;
use src\domain\money\Money;
use \Exception;

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
}
