<?php

namespace test\infrastructure\loan;

use PHPUnit\Framework\TestCase;
use src\domain\loan\DefaultLoan;
use src\domain\loan\LoanId;
use src\domain\loan\LoanInterval;
use src\infrastructure\application\loan\InMemoryLoanRepository;
use \DateTime;

class InMemoryLoanRepositoryTest extends TestCase
{
    public function testAddAndRetrieve()
    {
        $repository = new InMemoryLoanRepository();
        $repository
            ->add(
                new DefaultLoan(
                    new LoanId(1),
                    new LoanInterval(new DateTime('2016-03-26'), new DateTime('2016-05-13'))
                )
            )
        ;
        $this->assertTrue($repository->byId(new LoanId(1))->exists());
    }

    public function testFailedRetrieve()
    {
        $this->assertFalse((new InMemoryLoanRepository())->byId(new LoanId(1))->exists());
    }
}
