<?php

namespace src\useCases\investInTranche\command;

use src\domain\investor\InvestorId;
use src\domain\investor\InvestorRepository;
use src\domain\loan\LoanId;
use src\domain\loan\LoanRepository;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\domain\tranche\Tranche;
use src\domain\tranche\TrancheId;
use src\domain\tranche\TrancheRepository;
use src\useCases\Request;
use \DateTime;

class ValidatedInvestInTrancheCommand
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var LoanRepository
     */
    private $loanRepository;

    /**
     * @var TrancheRepository
     */
    private $trancheRepository;

    /**
     * @var InvestorRepository
     */
    private $investorRepository;

    /**
     * @var DateTime
     */
    private $currentDateTime;

    public function __construct(
        array $data,
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        DateTime $currentDateTime
    )
    {
        $this->data = $data;
        $this->loanRepository = $loanRepository;
        $this->trancheRepository = $trancheRepository;
        $this->investorRepository = $investorRepository;
        $this->currentDateTime = $currentDateTime;
    }

    public function result()
    {
        if (!empty($errors = $this->validationErrors())) {
            return new InvalidInvestInTrancheCommand($errors);
        }

        $tranche = $this->tranche();

        if (!$tranche->exists()) {
            return new InvalidInvestInTrancheCommand(['Tranche does not exist.']);
        }

        if ($this->isLoanClosed($tranche->loanId())) {
            return new InvalidInvestInTrancheCommand(['Loan is closed.']);
        }

        if ($this->amountIsTooBig($tranche)) {
            return new InvalidInvestInTrancheCommand(['Amount is too big.']);
        }

        $investor = $this->investor();

        $moneyToInvest = $this->moneyToInvest();

        if (!$investor->hasEnoughMoney($moneyToInvest)) {
            return new InvalidInvestInTrancheCommand(['An investor does not have enough money.']);
        }

        return new ValidInvestInTrancheCommand($tranche, $investor, $moneyToInvest);
    }

    private function validationErrors()
    {
        $errors = [];

        if (!isset($this->data['tranche_id'])) {
            $errors[] = 'tranche_id is required.';
        }
        if (!isset($this->data['investor_id'])) {
            $errors[] = 'investor_id is required.';
        }
        if (!isset($this->data['amount'])) {
            $errors[] = 'amount is required.';
        }

        return $errors;
    }

    private function isLoanClosed(LoanId $loanId)
    {
        return
            $this->loanRepository
                ->byId($loanId)
                    ->isClosed($this->currentDateTime)
            ;
    }

    private function amountIsTooBig(Tranche $tranche)
    {
        return
            !$tranche->canAccept(
                new InMinorUnits(
                    $this->data['amount'],
                    new Pound()
                )
            );
    }

    private function tranche()
    {
        return
            $this->trancheRepository
                ->byId(
                    new TrancheId($this->data['tranche_id'])
                )
            ;
    }

    private function investor()
    {
        return
            $this->investorRepository
                ->byId(
                    new InvestorId(
                        $this->data['investor_id']
                    )
                )
            ;
    }

    private function moneyToInvest()
    {
        return
            new InMinorUnits(
                $this->data['amount'],
                new Pound()
            );
    }
}
