<?php

namespace src\domain\investment;

use src\domain\investor\InvestorId;
use src\domain\money\Money;
use \DateTime;

interface Investment
{
    /**
     * @return InvestmentId
     */
    public function id();

    /**
     * @return Money
     */
    public function amount();

    /**
     * @param InvestorId $investorId
     * @return bool
     */
    public function belongsTo(InvestorId $investorId);

    /**
     * @param DateTime $finish
     * @return bool
     */
    public function isBefore(DateTime $finish);

    /**
     * @param DateTime $start
     * @param DateTime $finish
     * @return Money
     */
    public function calculateFor(DateTime $start, DateTime $finish);
}
