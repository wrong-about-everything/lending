<?php

namespace src\useCases\investInTranche;

use src\domain\investment\FixedInterestPercentageInvestment;
use src\domain\investor\InvestorRepository;
use src\domain\loan\LoanRepository;
use src\domain\tranche\TrancheRepository;
use src\useCases\investInTranche\command\ValidatedInvestInTrancheCommand;
use src\useCases\UseCase;
use \DateTime;

class InvestInTranche implements UseCase
{
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
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        DateTime $currentDateTime
    )
    {
        $this->loanRepository = $loanRepository;
        $this->trancheRepository = $trancheRepository;
        $this->investorRepository = $investorRepository;
        $this->currentDateTime = $currentDateTime;
    }

    public function act(array $data)
    {
        $validationResult =
            (new ValidatedInvestInTrancheCommand(
                $data,
                $this->loanRepository,
                $this->trancheRepository,
                $this->investorRepository,
                $this->currentDateTime
            ))
                ->result()
        ;

        if (!$validationResult->isSuccessful()) {
            return $validationResult->errors();
        }

        $validationResult->investor()
            ->invest(
                new FixedInterestPercentageInvestment(
                    $validationResult->investor()->id(),
                    $this->currentDateTime,
                    $validationResult->tranche()->percentage(),
                    $validationResult->moneyToInvest()
                )
            )
        ;

        $validationResult->tranche()->transfer($validationResult->moneyToInvest());

        return ['code' => 'ok'];
    }
}
