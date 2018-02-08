<?php

namespace src\domain\loan;

use \DateTime;

class DefaultLoan implements Loan
{
    /**
     * @var LoanId
     */
    private $id;

    /**
     * @var LoanInterval
     */
    private $interval;

    public function __construct(LoanId $id, LoanInterval $interval)
    {
        $this->id = $id;
        $this->interval = $interval;
    }

    public function exists()
    {
        return true;
    }

    public function id()
    {
        return $this->id;
    }

    public function isClosed(DateTime $now)
    {
        return $this->interval->isClosed($now);
    }
}

