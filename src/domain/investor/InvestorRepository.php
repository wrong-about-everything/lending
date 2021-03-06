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
}