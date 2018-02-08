<?php

namespace src\useCases\investInTranche;

use src\domain\investment\FixedInterestPercentageInvestment;
use src\domain\investment\InvestmentRepository;
use src\domain\investor\InvestorRepository;
use src\domain\loan\LoanRepository;
use src\domain\tranche\TrancheRepository;
use src\useCases\investInTranche\command\ValidatedInvestInTrancheCommand;
use src\useCases\Request;
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
     * @var InvestmentRepository
     */
    private $investmentRepository;

    /**
     * @var DateTime
     */
    private $currentDateTime;

    public function __construct(
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        InvestmentRepository $investmentRepository,
        DateTime $currentDateTime
    )
    {
        $this->loanRepository = $loanRepository;
        $this->trancheRepository = $trancheRepository;
        $this->investorRepository = $investorRepository;
        $this->investmentRepository = $investmentRepository;
        $this->currentDateTime = $currentDateTime;
    }

    public function act(Request $request)
    {
        $validationResult =
            (new ValidatedInvestInTrancheCommand(
                $request,
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

        $this->investmentRepository
            ->add(
                new FixedInterestPercentageInvestment(
                    $this->investmentRepository->generateId(),
                    $validationResult->investor()->id(),
                    $this->currentDateTime,
                    $validationResult->tranche()->percentage(),
                    $validationResult->moneyToInvest()
                )
            )
        ;

        $validationResult->investor()
            ->invest(
                new FixedInterestPercentageInvestment(
                    $this->investmentRepository->generateId(),
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