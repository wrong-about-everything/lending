<?php

namespace test\useCases\investInTranche;

use \PHPUnit\Framework\TestCase;
use \DateTime;
use src\domain\investment\InvestmentRepository;
use src\domain\percentage\format\DefaultPercent;
use \src\infrastructure\investment\InMemoryInvestmentRepository;
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

class LendInvestCodingScenarioTest extends TestCase
{
    public function test()
    {
        $loanRepository = $this->filledLoanRepository();
        $trancheRepository = $this->filledTrancheRepository();
        $investorRepository = $this->filledInvestorRepository();
        $investmentRepository = $this->emptyInvestmentRepository();

        $this->runFirstCase(
            $loanRepository,
            $trancheRepository,
            $investorRepository,
            $investmentRepository
        );

        $this->runSecondCase(
            $loanRepository,
            $trancheRepository,
            $investorRepository,
            $investmentRepository
        );

        $this->runThirdCase(
            $loanRepository,
            $trancheRepository,
            $investorRepository,
            $investmentRepository
        );

        $this->runFourthCase(
            $loanRepository,
            $trancheRepository,
            $investorRepository,
            $investmentRepository
        );
    }

    private function runFirstCase(
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        InvestmentRepository $investmentRepository
    )
    {
        $response1 =
            (new InvestInTranche(
                $loanRepository,
                $trancheRepository,
                $investorRepository,
                $investmentRepository,
                $this->investor1Date()
            ))
                ->act(
                    new FromArray(
                        [
                            'amount' => $this->investor1Amount(),
                            'tranche_id' => $this->trancheAId(),
                            'investor_id' => $this->investor1Id(),
                        ]
                    )
                )
        ;

        $this->assertAmountTransferredByInvestor1InTrancheA($trancheRepository);
        $this->assertInvestors1WalletAmountDecreased($investorRepository);
        $this->assertInvestors1Interest($investmentRepository);
        $this->assertResponseCode1($response1);
    }

    private function runSecondCase(
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        InvestmentRepository $investmentRepository
    )
    {
        $response2 =
            (new InvestInTranche(
                $loanRepository,
                $trancheRepository,
                $investorRepository,
                $investmentRepository,
                $this->investor2Date()
            ))
                ->act(
                    new FromArray(
                        [
                            'amount' => $this->investor2Amount(),
                            'tranche_id' => $this->trancheAId(),
                            'investor_id' => $this->investor2Id(),
                        ]
                    )
                )
        ;

        $this->assertNoAmountTransferredByInvestor2InTrancheA($trancheRepository);
        $this->assertInvestors2WalletAmountStayedTheSame($investorRepository);
        $this->assertInvestors2Interest($investmentRepository);
        $this->assertResponseCode2($response2);
    }

    private function runThirdCase(
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        InvestmentRepository $investmentRepository
    )
    {
        $response3 =
            (new InvestInTranche(
                $loanRepository,
                $trancheRepository,
                $investorRepository,
                $investmentRepository,
                $this->investor3Date()
            ))
                ->act(
                    new FromArray(
                        [
                            'amount' => $this->investor3Amount(),
                            'tranche_id' => $this->trancheBId(),
                            'investor_id' => $this->investor3Id(),
                        ]
                    )
                )
        ;

        $this->assertAmountTransferredByInvestor3InTrancheB($trancheRepository);
        $this->assertInvestors3WalletAmountDecreased($investorRepository);
        $this->assertInvestors3Interest($investmentRepository);
        $this->assertResponseCode3($response3);
    }

    private function runFourthCase(
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        InvestmentRepository $investmentRepository
    )
    {
        $response4 =
            (new InvestInTranche(
                $loanRepository,
                $trancheRepository,
                $investorRepository,
                $investmentRepository,
                $this->investor4Date()
            ))
                ->act(
                    new FromArray(
                        [
                            'amount' => $this->investor4Amount(),
                            'tranche_id' => $this->trancheBId(),
                            'investor_id' => $this->investor4Id(),
                        ]
                    )
                )
        ;

        $this->assertNoAmountTransferredByInvestor4InTrancheB($trancheRepository);
        $this->assertInvestors4WalletAmountStayedTheSame($investorRepository);
        $this->assertInvestors4Interest($investmentRepository);
        $this->assertResponseCode4($response4);
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
            )
        ;

        return $loanRepository;
    }

    private function filledTrancheRepository()
    {
        $trancheRepository = new InMemoryTrancheRepository();

        $trancheRepository
            ->add(
                new DefaultTranche(
                    new TrancheId($this->trancheAId()),
                    new LoanId($this->loanId()),
                    new InMinorUnits($this->initialTrancheAmount(), new Pound()),
                    new InMinorUnits($this->trancheMaximumAvailableAmount(), new Pound()),
                    $this->trancheAInterestRate()
                )
            )
        ;

        $trancheRepository
            ->add(
                new DefaultTranche(
                    new TrancheId($this->trancheBId()),
                    new LoanId($this->loanId()),
                    new InMinorUnits($this->initialTrancheAmount(), new Pound()),
                    new InMinorUnits($this->trancheMaximumAvailableAmount(), new Pound()),
                    $this->trancheBInterestRate()
                )
            )
        ;

        return $trancheRepository;
    }

    private function filledInvestorRepository()
    {
        $investorRepository = new InMemoryInvestorRepository();

        $investorRepository
            ->add(
                new DefaultInvestor(
                    new InvestorId($this->investor1Id()),
                    new InMinorUnits($this->initialAmountInInvestors1Wallet(), new Pound())
                )
            )
        ;

        $investorRepository
            ->add(
                new DefaultInvestor(
                    new InvestorId($this->investor2Id()),
                    new InMinorUnits($this->initialAmountInInvestors2Wallet(), new Pound())
                )
            )
        ;

        $investorRepository
            ->add(
                new DefaultInvestor(
                    new InvestorId($this->investor3Id()),
                    new InMinorUnits($this->initialAmountInInvestors3Wallet(), new Pound())
                )
            )
        ;

        $investorRepository
            ->add(
                new DefaultInvestor(
                    new InvestorId($this->investor4Id()),
                    new InMinorUnits($this->initialAmountInInvestors4Wallet(), new Pound())
                )
            )
        ;

        return $investorRepository;
    }

    private function emptyInvestmentRepository()
    {
        return new InMemoryInvestmentRepository();
    }

    private function investInTranche(
        LoanRepository $loanRepository,
        TrancheRepository $trancheRepository,
        InvestorRepository $investorRepository,
        InvestmentRepository $investmentRepository,
        $investorId,
        $trancheId,
        $amount
    )
    {
        return
            (new InvestInTranche(
                $loanRepository,
                $trancheRepository,
                $investorRepository,
                $investmentRepository,
                new DateTime('2015-10-03')
            ))
                ->act(
                    new FromArray(
                        [
                            'amount' => $amount,
                            'tranche_id' => $trancheId,
                            'investor_id' => $investorId,
                        ]
                    )
                )
            ;
    }

    private function assertAmountTransferredByInvestor1InTrancheA(TrancheRepository $trancheRepository)
    {
        $this->assertEquals(
            $this->investor1Amount(),
            $trancheRepository
                ->byId(
                    new TrancheId($this->trancheAId())
                )
                    ->currentInvestedAmount()
                        ->amount()
        );
    }

    private function assertNoAmountTransferredByInvestor2InTrancheA(TrancheRepository $trancheRepository)
    {
        $this->assertEquals(
            $this->investor1Amount(),
            $trancheRepository
                ->byId(
                    new TrancheId($this->trancheAId())
                )
                    ->currentInvestedAmount()
                        ->amount()
        );
    }

    private function assertAmountTransferredByInvestor3InTrancheB(TrancheRepository $trancheRepository)
    {
        $this->assertEquals(
            $this->investor3Amount(),
            $trancheRepository
                ->byId(
                    new TrancheId($this->trancheBId())
                )
                    ->currentInvestedAmount()
                        ->amount()
        );
    }

    private function assertNoAmountTransferredByInvestor4InTrancheB(TrancheRepository $trancheRepository)
    {
        $this->assertEquals(
            $this->investor3Amount(),
            $trancheRepository
                ->byId(
                    new TrancheId($this->trancheBId())
                )
                    ->currentInvestedAmount()
                        ->amount()
        );
    }

    private function assertInvestors1WalletAmountDecreased(InvestorRepository $investorRepository)
    {
        $this->assertEquals(
            $this->initialAmountInInvestors1Wallet() - $this->investor1Amount(),
            $investorRepository->byId(new InvestorId($this->investor1Id()))->walletAmount()->amount()
        );
    }

    private function assertInvestors2WalletAmountStayedTheSame(InvestorRepository $investorRepository)
    {
        $this->assertEquals(
            $this->initialAmountInInvestors2Wallet(),
            $investorRepository->byId(new InvestorId($this->investor2Id()))->walletAmount()->amount()
        );
    }

    private function assertInvestors3WalletAmountDecreased(InvestorRepository $investorRepository)
    {
        $this->assertEquals(
            $this->initialAmountInInvestors3Wallet() - $this->investor3Amount(),
            $investorRepository->byId(new InvestorId($this->investor3Id()))->walletAmount()->amount()
        );
    }

    private function assertInvestors4WalletAmountStayedTheSame(InvestorRepository $investorRepository)
    {
        $this->assertEquals(
            $this->initialAmountInInvestors4Wallet(),
            $investorRepository->byId(new InvestorId($this->investor4Id()))->walletAmount()->amount()
        );
    }

    private function assertInvestors1Interest(InvestmentRepository $investmentRepository)
    {
        $this->assertEquals(
            2806,
            $investmentRepository->calculate(
                new InvestorId($this->investor1Id()),
                new DateTime('2015-10-01'),
                new DateTime('2015-10-31')
            )
                ->amount()
        );
    }

    private function assertInvestors2Interest(InvestmentRepository $investmentRepository)
    {
        $this->assertEquals(
            0,
            $investmentRepository->calculate(
                new InvestorId($this->investor2Id()),
                new DateTime('2015-10-01'),
                new DateTime('2015-10-31')
            )
                ->amount()
        );
    }

    private function assertInvestors3Interest(InvestmentRepository $investmentRepository)
    {
        $this->assertEquals(
            2129,
            $investmentRepository->calculate(
                new InvestorId($this->investor3Id()),
                new DateTime('2015-10-01'),
                new DateTime('2015-10-31')
            )
                ->amount()
        );
    }

    private function assertInvestors4Interest(InvestmentRepository $investmentRepository)
    {
        $this->assertEquals(
            0,
            $investmentRepository->calculate(
                new InvestorId($this->investor4Id()),
                new DateTime('2015-10-01'),
                new DateTime('2015-10-31')
            )
                ->amount()
        );
    }

    private function assertResponseCode1(array $response)
    {
        $this->assertEquals('ok', $response['code']);
    }

    private function assertResponseCode2(array $response)
    {
        $this->assertEquals('exception', $response['code']);
    }

    private function assertResponseCode3(array $response)
    {
        $this->assertEquals('ok', $response['code']);
    }

    private function assertResponseCode4(array $response)
    {
        $this->assertEquals('exception', $response['code']);
    }

    private function trancheAInterestRate()
    {
        return new DefaultPercent(3);
    }

    private function trancheBInterestRate()
    {
        return new DefaultPercent(6);
    }

    private function loanId()
    {
        return 1;
    }

    private function trancheAId()
    {
        return 1;
    }

    private function trancheBId()
    {
        return 2;
    }

    private function investor1Id()
    {
        return 1;
    }

    private function investor2Id()
    {
        return 2;
    }

    private function investor3Id()
    {
        return 3;
    }

    private function investor4Id()
    {
        return 4;
    }

    private function initialTrancheAmount()
    {
        return 0;
    }

    private function trancheMaximumAvailableAmount()
    {
        return 100000;
    }

    private function initialAmountInInvestors1Wallet()
    {
        return 100000;
    }

    private function initialAmountInInvestors2Wallet()
    {
        return 100000;
    }

    private function initialAmountInInvestors3Wallet()
    {
        return 100000;
    }

    private function initialAmountInInvestors4Wallet()
    {
        return 100000;
    }

    private function investor1Amount()
    {
        return 100000;
    }

    private function investor2Amount()
    {
        return 100;
    }

    private function investor3Amount()
    {
        return 50000;
    }

    private function investor4Amount()
    {
        return 110000;
    }

    private function investor1Date()
    {
        return new DateTime('2015-10-03');
    }

    private function investor2Date()
    {
        return new DateTime('2015-10-04');
    }

    private function investor3Date()
    {
        return new DateTime('2015-10-10');
    }

    private function investor4Date()
    {
        return new DateTime('2015-10-25');
    }
}
