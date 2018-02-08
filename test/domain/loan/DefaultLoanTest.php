<?php

namespace test\domain\loan;

use PHPUnit\Framework\TestCase;
use src\domain\loan\DefaultLoan;
use src\domain\loan\LoanId;
use src\domain\loan\LoanInterval;
use \DateTime;

class DefaultLoanTest extends TestCase
{
    public function testIsClosed()
    {
        $this->assertTrue(
            (new DefaultLoan(
                new LoanId(1),
                new LoanInterval(new DateTime('2015-10-01'), new DateTime('2015-10-31'))
            ))
                ->isClosed(new DateTime('2015-11-01'))
        );
    }

    public function testIsOpen()
    {
        $this->assertFalse(
            (new DefaultLoan(
                new LoanId(1),
                new LoanInterval(new DateTime('2015-10-01'), new DateTime('2015-10-31'))
            ))
                ->isClosed(new DateTime('2015-10-02'))
        );
    }
}

