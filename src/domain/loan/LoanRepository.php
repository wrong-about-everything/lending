<?php

namespace src\domain\loan;

interface LoanRepository
{
    /**
     * @param LoanId $loanId
     * @return Loan
     */
    public function byId(LoanId $loanId);

    public function add(Loan $loan);
}