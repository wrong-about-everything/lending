<?php

namespace src\infrastructure\application\loan;

use src\domain\loan\Loan;
use src\domain\loan\LoanId;
use src\domain\loan\LoanRepository;
use src\domain\loan\NonExistentLoan;

class InMemoryLoanRepository implements LoanRepository
{
    private $loans;

    public function __construct()
    {
        $this->loans = [];
    }

    public function byId(LoanId $loanId)
    {
        if (!isset($this->loans[$loanId->id()])) {
            return new NonExistentLoan();
        }

        return $this->loans[$loanId->id()];
    }

    public function add(Loan $loan)
    {
        $this->loans[$loan->id()->id()] = $loan;
    }
}