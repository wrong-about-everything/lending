<?php

namespace src\domain\loan;

use \Exception;
use \DateTime;

class NonExistentLoan implements Loan
{
    public function exists(): bool
    {
        return false;
    }

    public function id(): LoanId
    {
        throw new Exception('The loan you are operating upon does not exist.');
    }

    public function isClosed(DateTime $now): bool
    {
        throw new Exception('The loan you are operating upon does not exist.');
    }
}
