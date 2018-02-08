<?php

namespace test\domain\tranche;

use \PHPUnit\Framework\TestCase;
use \src\domain\loan\LoanId;
use \src\domain\money\currency\Pound;
use \src\domain\money\format\InMinorUnits;
use \src\domain\percentage\format\DefaultPercent;
use \src\domain\tranche\DefaultTranche;
use \src\domain\tranche\TrancheId;
use \Exception;

class DefaultTrancheTest extends TestCase
{
    public function testSuccessfulTransfer()
    {
        $tranche =
            new DefaultTranche(
                new TrancheId(1),
                new LoanId(1),
                new InMinorUnits(100, new Pound()),
                new InMinorUnits(1000, new Pound()),
                new DefaultPercent(5)
            );

        $tranche->transfer(
            new InMinorUnits(900, new Pound())
        );

        $this->assertEquals(1000, $tranche->currentInvestedAmount()->amount());
    }

    /**
     * @expectedException Exception
     */
    public function testFailedTransfer()
    {
        $tranche =
            new DefaultTranche(
                new TrancheId(1),
                new LoanId(1),
                new InMinorUnits(100, new Pound()),
                new InMinorUnits(1000, new Pound()),
                new DefaultPercent(5)
            );

        $tranche->transfer(
            new InMinorUnits(901, new Pound())
        );

        $this->assertEquals(1000, $tranche->currentInvestedAmount()->amount());
    }
}
