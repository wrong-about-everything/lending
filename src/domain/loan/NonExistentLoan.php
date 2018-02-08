<?php

namespace src\domain\loan;

use \Exception;
use \DateTime;

class NonExistentLoan implements Loan
{
    public function exists()
    {
        return false;
    }

    public function id()
    {
        throw new Exception('The loan you are operating upon does not exist.');
    }

    public function isClosed(DateTime $now)
    {
        throw new Exception('The loan you are operating upon does not exist.');
    }
}
