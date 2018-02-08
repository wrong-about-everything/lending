<?php

namespace src\domain\tranche;

use \Exception;
use src\domain\money\Money;

class NonExistentTranche implements Tranche
{
    public function exists()
    {
        return false;
    }

    public function id()
    {
        throw new Exception('Tranche does not exist.');
    }

    public function loanId()
    {
        throw new Exception('Tranche does not exist.');
    }

    public function currentInvestedAmount()
    {
        throw new Exception('Tranche does not exist.');
    }

    public function percentage()
    {
        throw new Exception('Tranche does not exist.');
    }

    public function canAccept(Money $money)
    {
        throw new Exception('Tranche does not exist.');
    }

    public function transfer(Money $money)
    {
        throw new Exception('Tranche does not exist.');
    }
}