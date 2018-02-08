<?php

namespace src\domain\investor;

use \Exception;
use src\domain\investment\Investment;
use src\domain\money\Money;

class NonExistentInvestor implements Investor
{
    public function exists()
    {
        return false;
    }

    public function id()
    {
        throw new Exception('The investor you are operating upon does not exist.');
    }

    public function walletAmount()
    {
        throw new Exception('The investor you are operating upon does not exist.');
    }

    public function hasEnoughMoney(Money $money)
    {
        throw new Exception('The investor you are operating upon does not exist.');
    }

    public function invest(Investment $investment)
    {
        throw new Exception('The investor you are operating upon does not exist.');
    }
}
