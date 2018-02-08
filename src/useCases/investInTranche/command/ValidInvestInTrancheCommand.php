<?php

namespace src\useCases\investInTranche\command;

use src\domain\investor\Investor;
use src\domain\money\Money;
use src\domain\tranche\Tranche;
use src\useCases\investInTranche\InvestInTrancheCommand;

class ValidInvestInTrancheCommand implements InvestInTrancheCommand
{
    /**
     * @var Tranche
     */
    private $tranche;

    /**
     * @var Investor
     */
    private $investor;

    /**
     * @var Money
     */
    private $moneyToInvest;

    public function __construct(Tranche $tranche, Investor $investor, Money $moneyToInvest)
    {
        $this->tranche = $tranche;
        $this->investor = $investor;
        $this->moneyToInvest = $moneyToInvest;
    }

    public function isSuccessful()
    {
        return true;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [];
    }

    public function investor()
    {
        return $this->investor;
    }

    public function tranche()
    {
        return $this->tranche;
    }

    public function moneyToInvest()
    {
        return $this->moneyToInvest;
    }
}