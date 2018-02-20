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

    public function exists(): bool
    {
        return true;
    }

    public function id(): LoanId
    {
        return $this->id;
    }

    public function isClosed(DateTime $now): bool
    {
        return $this->interval->isClosed($now);
    }
}

