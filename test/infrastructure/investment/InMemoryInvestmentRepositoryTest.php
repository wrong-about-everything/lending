<?php

namespace test\infrastructure\investment;

use \PHPUnit\Framework\TestCase;
use \src\domain\investment\FixedInterestPercentageInvestment;
use \src\domain\investment\InvestmentId;
use \src\domain\investor\InvestorId;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\domain\percentage\format\DefaultPercent;
use \src\infrastructure\investment\InMemoryInvestmentRepository;
use \DateTime;

class InMemoryInvestmentRepositoryTest extends TestCase
{
    public function testCalculate()
    {
        $this->assertEquals(
            round(32154 * 0.05 + 9657 * 0.07 * 3 / 26),
            $this->filledRepository()
                ->calculate(
                    new InvestorId(1),
                    new DateTime('2017-05-01'),
                    new DateTime('2017-05-26')
                )
                    ->amount()
        );
    }

    private function filledRepository()
    {
        $repository = new InMemoryInvestmentRepository();

        $repository
            ->add(
                new FixedInterestPercentageInvestment(
                    new InvestmentId(1),
                    new InvestorId(1),
                    new DateTime('2017-04-21'),
                    new DefaultPercent(5),
                    new InMinorUnits(32154, new Pound())
                )
            )
        ;

        $repository
            ->add(
                new FixedInterestPercentageInvestment(
                    new InvestmentId(3),
                    new InvestorId(2),
                    new DateTime('2017-05-09'),
                    new DefaultPercent(9),
                    new InMinorUnits(5245, new Pound())
                )
            )
        ;

        $repository
            ->add(
                new FixedInterestPercentageInvestment(
                    new InvestmentId(2),
                    new InvestorId(1),
                    new DateTime('2017-05-24'),
                    new DefaultPercent(7),
                    new InMinorUnits(9657, new Pound())
                )
            )
        ;

        $repository
            ->add(
                new FixedInterestPercentageInvestment(
                    new InvestmentId(4),
                    new InvestorId(1),
                    new DateTime('2017-06-15'),
                    new DefaultPercent(6),
                    new InMinorUnits(3215, new Pound())
                )
            )
        ;

        return $repository;
    }
}