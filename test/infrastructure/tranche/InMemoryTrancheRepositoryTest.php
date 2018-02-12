<?php

namespace test\infrastructure\tranche;

use PHPUnit\Framework\TestCase;
use src\domain\loan\LoanId;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\domain\money\Money;
use src\domain\percentage\format\DefaultPercent;
use src\domain\percentage\Percentage;
use src\domain\tranche\DefaultTranche;
use src\domain\tranche\TrancheId;
use src\infrastructure\application\tranche\InMemoryTrancheRepository;
use \DateTime;

class InMemoryTrancheRepositoryTest extends TestCase
{
    public function testAddAndRetrieve()
    {
        $repository = new InMemoryTrancheRepository();
        $repository
            ->add(
                new DefaultTranche(
                    new TrancheId(1),
                    new LoanId(1),
                    new InMinorUnits(32132, new Pound()),
                    new InMinorUnits(6546987, new Pound()),
                    new DefaultPercent(9)
                )
            )
        ;
        $this->assertTrue($repository->byId(new TrancheId(1))->exists());
    }

    public function testFailedRetrieve()
    {
        $this->assertFalse((new InMemoryTrancheRepository())->byId(new TrancheId(1))->exists());
    }
}
