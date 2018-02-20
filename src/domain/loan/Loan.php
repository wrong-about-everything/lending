<?php

namespace src\domain\loan;

use \Exception;
use \DateTime;

interface Loan
{
    public function exists(): bool;

    /**
     * @return LoanId
     *
     * @throws Exception If current loan does not exist.
     */
    public function id(): LoanId;

    /**
     * @param $now DateTime Current datetime.
     * @return bool
     *
     * @throws Exception If current loan does not exist.
     */
    public function isClosed(DateTime $now): bool;
}