<?php

namespace src\domain\loan;

use \DateTime;

class LoanInterval
{
    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var DateTime
     */
    private $finish;

    public function __construct(DateTime $start, DateTime $finish)
    {
        $this->start = $start;
        $this->finish = $finish;
    }

    public function isClosed(DateTime $now)
    {
        return $now > $this->finish;
    }
}