<?php

namespace test\useCases\investInTranche;

use \PHPUnit\Framework\TestCase;
use \DateTime;
use src\domain\percentage\format\DefaultPercent;
use \src\useCases\investInTranche\InvestInTranche;
use \src\useCases\investInTranche\request\FromArray;
use \src\infrastructure\loan\InMemoryLoanRepository;
use \src\infrastructure\tranche\InMemoryTrancheRepository;
use \src\infrastructure\investor\InMemoryInvestorRepository;
use \src\domain\tranche\DefaultTranche;
use \src\domain\tranche\TrancheId;
use \src\domain\loan\LoanId;
use \src\domain\loan\DefaultLoan;
use \src\domain\loan\LoanInterval;
use src\domain\money\format\InMinorUnits;
use \src\domain\money\currency\Pound;
use \src\domain\investor\InvestorId;
use \src\domain\investor\DefaultInvestor;
use \src\domain\tranche\TrancheRepository;
use \src\domain\investor\InvestorRepository;
use \src\domain\loan\LoanRepository;

class FailedInvestInTrancheTest extends TestCase
{
    public function test()
    {
        $loanRepository = $this->filledLoanRepository();
        $trancheRepository = $this->filledTrancheRepository();
        $investorRepository = $this->filledInvestorRepository();

        $response = $this->investInTranche($loanRepository, $trancheRepository, $investorRepository);

        $this->assertNoInvestmentsMade($investorRepository);
        $this->assertNothingTransferredInTranche($trancheRepository);
        $this->assertInvestorsWalletAmountIsTheSame($investorRepository);
        $this->assertResponseCode($response);
    }

    private function filledLoanRepository()
    {
        $loanRepository = new InMemoryLoanRepository();

        $loanRepository
            ->add(
                new DefaultLoan(
                    new LoanId($this->loanId()),
                    new LoanInterval(
                        new DateTime('2015-10-01'),
                        new DateTime('2015-11-15')
                    )
                )
            );

        return $loanRepository;
    }

    private function filledTrancheRepository()
    {
        $trancheRepository = new InMemoryTrancheRepository();

        $trancheRepository
            ->add(
                new DefaultTranche(
                    new TrancheId($this->trancheId()),
                    new LoanId($this->loanId()),
                    new InMinorUnits($this->initialTrancheAmount(), new Pound()),
                    new InMinorUnits($this->trancheMaximumAvailableAmount(), new Pound()),
                    new DefaultPercent(2)
                )
            );

        return $trancheRepository;
    }

    private function filledInvestorRepository()
    {
        $investorRepository = new InMemoryInvestorRepository();

        $investorRepository
            ->add(
                new DefaultInvestor(
                    new InvestorId($this->investorId()),
                    new InMinorUnits($this->initialAmountInInvestorsWallet(), new Pound())
                )
            );

        return $investorRepository;
    }

    private function investInTranche(
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository
    )
    {
        return
            (new InvestInTranche(
                $loanRepository,
                $trancheRepository,
                $investorRepository,
                new DateTime('2015-12-03')
            ))
                ->act(
                    new FromArray(
                        [
                            'amount' => $this->amountToBeInvested(),
                            'tranche_id' => $this->trancheId(),
                            'investor_id' => $this->investorId(),
                        ]
                    )
                );
    }

    private function assertNoInvestmentsMade(InvestorRepository $investorRepository)
    {
        $this->assertEquals(
            new InMinorUnits(0, new Pound()),
            $investorRepository
                ->byId(
                    new InvestorId($this->investorId())
                )
                    ->calculate(
                        new DateTime('2000-10-01'),
                        new DateTime('now')
                    )
        );
    }

    private function assertNothingTransferredInTranche(TrancheRepository $trancheRepository)
    {
        $this->assertEquals(
            $this->initialTrancheAmount(),
            $trancheRepository
                ->byId(
                    new TrancheId($this->trancheId())
                )
                    ->currentInvestedAmount()
                        ->amount()
        );
    }

    private function assertInvestorsWalletAmountIsTheSame(InvestorRepository $investorRepository)
    {
        $this->assertEquals(
            $this->initialAmountInInvestorsWallet(),
            $investorRepository->byId(new InvestorId($this->investorId()))->walletAmount()->amount()
        );
    }

    private function assertResponseCode(array $response)
    {
        $this->assertEquals('exception', $response['code']);
    }

    private function loanId()
    {
        return 1;
    }

    private function trancheId()
    {
        return 1;
    }

    private function investorId()
    {
        return 1;
    }

    private function initialTrancheAmount()
    {
        return 0;
    }

    private function trancheMaximumAvailableAmount()
    {
        return 100000;
    }

    private function initialAmountInInvestorsWallet()
    {
        return 100000;
    }

    private function amountToBeInvested()
    {
        return 30000;
    }
}
