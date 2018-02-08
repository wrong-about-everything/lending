<?php

namespace src\domain\loan;

use \Exception;
use \DateTime;

interface Loan
{
    /**
     * @return bool
     */
    public function exists();

    /**
     * @return LoanId
     *
     * @throws Exception If current loan does not exist.
     */
    public function id();

    /**
     * @param $now DateTime Current datetime.
     * @return bool
     *
     * @throws Exception If current loan does not exist.
     */
    public function isClosed(DateTime $now);
}