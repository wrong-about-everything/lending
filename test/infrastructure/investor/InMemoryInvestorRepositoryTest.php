<?php

namespace test\infrastructure\investor;

use PHPUnit\Framework\TestCase;
use src\domain\investor\DefaultInvestor;
use src\domain\investor\InvestorId;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\infrastructure\domain\investor\InMemoryInvestorRepository;

class InMemoryInvestorRepositoryTest extends TestCase
{
    public function testAddAndRetrieve()
    {
        $repository = new InMemoryInvestorRepository();
        $repository
            ->add(
                new DefaultInvestor(
                    new InvestorId(1),
                    new InMinorUnits(3215, new Pound())
                )
            )
        ;
        $this->assertTrue($repository->byId(new InvestorId(1))->exists());
    }

    public function testFailedRetrieve()
    {
        $this->assertFalse((new InMemoryInvestorRepository())->byId(new InvestorId(1))->exists());
    }
}
