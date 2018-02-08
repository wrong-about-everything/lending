<?php

namespace src\domain\investment;

use src\domain\investor\InvestorId;
use \DateTime;
use src\domain\money\Money;

interface InvestmentRepository
{
    /**
     * @param InvestorId $investorId
     * @param DateTime $start
     * @param DateTime $finish
     * @return Money
     */
    public function calculate(InvestorId $investorId, DateTime $start, DateTime $finish);

    /**
     * @param Investment $investment
     * @return void
     */
    public function add(Investment $investment);

    /**
     * @return Investment[]
     */
    public function all();

    /**
     * @return InvestmentId
     */
    public function generateId();
}
