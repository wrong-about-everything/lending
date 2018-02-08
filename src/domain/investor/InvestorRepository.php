<?php

namespace src\domain\investor;

use src\domain\money\Money;
use \DateTime;

interface InvestorRepository
{
    /**
     * @param InvestorId $investorId
     * @return Investor
     */
    public function byId(InvestorId $investorId);

    public function add(Investor $investor);

    /**
     * @param InvestorId $investor
     * @return Money
     */
    public function calculate(InvestorId $investorId, DateTime $start, DateTime $finish);
}