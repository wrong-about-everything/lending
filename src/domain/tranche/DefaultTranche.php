<?php

namespace src\domain\tranche;

use src\domain\loan\LoanId;
use \Exception;
use src\domain\money\Money;
use src\domain\money\calculation\Sum;
use src\domain\percentage\Percentage;

class DefaultTranche implements Tranche
{
    /**
     * @var TrancheId
     */
    private $id;

    /**
     * @var LoanId
     */
    private $loanId;

    /**
     * @var Money
     */
    private $currentInvestedAmount;

    /**
     * @var Money
     */
    private $maximumAvailableAmount;

    /**
     * @var Percentage
     */
    private $percentage;

    public function __construct(TrancheId $trancheId, LoanId $loanId, Money $currentInvestedAmount, Money $maximumAvailableAmount, Percentage $percentage)
    {
        $this->id = $trancheId;
        $this->loanId = $loanId;
        $this->currentInvestedAmount = $currentInvestedAmount;
        $this->maximumAvailableAmount = $maximumAvailableAmount;
        $this->percentage = $percentage;
    }

    public function exists()
    {
        return true;
    }

    public function id()
    {
        return $this->id;
    }

    public function loanId()
    {
        return $this->loanId;
    }

    public function currentInvestedAmount()
    {
        return $this->currentInvestedAmount;
    }

    public function percentage()
    {
        return $this->percentage;
    }

    public function canAccept(Money $money)
    {
        return (new Sum($this->currentInvestedAmount, $money))->isLessOrEqual($this->maximumAvailableAmount);
    }

    public function transfer(Money $money)
    {
        if (!$this->canAccept($money)) {
            throw new Exception('Tranche can not be invested');
        }

        $this->currentInvestedAmount = new Sum($this->currentInvestedAmount, $money);
    }
}