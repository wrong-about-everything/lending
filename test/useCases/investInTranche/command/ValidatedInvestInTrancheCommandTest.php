<?php

namespace test\useCases\investInTranche\command;

use PHPUnit\Framework\TestCase;
use src\domain\investor\DefaultInvestor;
use src\domain\investor\InvestorId;
use src\domain\loan\DefaultLoan;
use src\domain\loan\LoanId;
use src\domain\loan\LoanInterval;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\domain\percentage\format\DefaultPercent;
use src\domain\tranche\DefaultTranche;
use src\domain\tranche\TrancheId;
use src\infrastructure\domain\investor\InMemoryInvestorRepository;
use src\infrastructure\domain\loan\InMemoryLoanRepository;
use src\infrastructure\domain\tranche\InMemoryTrancheRepository;
use src\useCases\investInTranche\command\ValidatedInvestInTrancheCommand;
use \DateTime;

class ValidatedInvestInTrancheCommandTest extends TestCase
{
    public function testSuccess()
    {
        $command =
            new ValidatedInvestInTrancheCommand(
                [
                    'tranche_id' => 1,
                    'investor_id' => 1,
                    'amount' => 12,
                ],
                $this->filledLoanRepository(),
                $this->filledTrancheRepository(),
                $this->filledInvestorRepository(),
                new DateTime('2015-03-01')
            )
        ;

        $this->assertTrue($command->result()->isSuccessful());
    }

    public function testAbsentFields()
    {
        $command =
            new ValidatedInvestInTrancheCommand(
                [],
                new InMemoryLoanRepository(),
                new InMemoryTrancheRepository(),
                new InMemoryInvestorRepository(),
                new DateTime('2016-02-17')
            )
        ;

        $this->assertEquals(
            ['code' => 'exception', 'tranche_id is required.', 'investor_id is required.', 'amount is required.'],
            $command->result()->errors()
        );
    }

    public function testTrancheDoesNotExist()
    {
        $command =
            new ValidatedInvestInTrancheCommand(
                [
                    'tranche_id' => 1,
                    'investor_id' => 1,
                    'amount' => 19856,
                ],
                new InMemoryLoanRepository(),
                new InMemoryTrancheRepository(),
                new InMemoryInvestorRepository(),
                new DateTime('2016-02-17')
            )
        ;

        $this->assertEquals(
            ['code' => 'exception', 'Tranche does not exist.'],
            $command->result()->errors()
        );
    }

    public function testLoanIsClosed()
    {
        $command =
            new ValidatedInvestInTrancheCommand(
                [
                    'tranche_id' => 1,
                    'investor_id' => 1,
                    'amount' => 19856,
                ],
                $this->filledLoanRepository(),
                $this->filledTrancheRepository(),
                new InMemoryInvestorRepository(),
                new DateTime('2016-02-17')
            )
        ;

        $this->assertEquals(
            ['code' => 'exception', 'Loan is closed.'],
            $command->result()->errors()
        );
    }

    public function testAmountIsTooBig()
    {
        $command =
            new ValidatedInvestInTrancheCommand(
                [
                    'tranche_id' => 1,
                    'investor_id' => 1,
                    'amount' => 19856654654,
                ],
                $this->filledLoanRepository(),
                $this->filledTrancheRepository(),
                new InMemoryInvestorRepository(),
                new DateTime('2015-03-01')
            )
        ;

        $this->assertEquals(
            ['code' => 'exception', 'Amount is too big.'],
            $command->result()->errors()
        );
    }

    public function testInvestorDoesNotHaveEnoughMoney()
    {
        $command =
            new ValidatedInvestInTrancheCommand(
                [
                    'tranche_id' => 1,
                    'investor_id' => 1,
                    'amount' => 71235,
                ],
                $this->filledLoanRepository(),
                $this->filledTrancheRepository(),
                $this->filledInvestorRepository(),
                new DateTime('2015-03-01')
            )
        ;

        $this->assertEquals(
            ['code' => 'exception', 'An investor does not have enough money.'],
            $command->result()->errors()
        );
    }

    private function filledLoanRepository()
    {
        $repository = new InMemoryLoanRepository();

        $repository
            ->add(
                new DefaultLoan(
                    new LoanId(1),
                    new LoanInterval(
                        new DateTime('2015-02-25'),
                        new DateTime('2015-03-25')
                    )
                )
            );

        return $repository;
    }

    private function filledTrancheRepository()
    {
        $repository = new InMemoryTrancheRepository();

        $repository
            ->add(
                new DefaultTranche(
                    new TrancheId(1),
                    new LoanId(1),
                    new InMinorUnits(212, new Pound()),
                    new InMinorUnits(87654, new Pound()),
                    new DefaultPercent(7)
                )
            );

        return $repository;
    }

    private function filledInvestorRepository()
    {
        $repository = new InMemoryInvestorRepository();

        $repository
            ->add(
                new DefaultInvestor(
                    new InvestorId(1),
                    new InMinorUnits(2211, new Pound())
                )
            );

        return $repository;
    }
}
