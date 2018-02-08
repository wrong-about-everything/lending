<?php

namespace src\domain\investor;

use src\domain\investment\Investment;
use src\domain\money\Money;
use \Exception;

interface Investor
{
    /**
     * @return bool
     */
    public function exists();

    /**
     * @return InvestorId
     *
     * @throws Exception
     */
    public function id();

    /**
     * @return Money
     *
     * @throws Exception
     */
    public function walletAmount();

    /**
     * @param Money $money
     * @return bool
     *
     * @throws Exception
     */
    public function hasEnoughMoney(Money $money);

    /**
     * @param Investment $investment
     * @return void
     *
     * @throws Exception
     */
    public function invest(Investment $investment);
}
