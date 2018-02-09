<?php

namespace test\domain\investment;

use PHPUnit\Framework\TestCase;
use \DateTime;
use \src\domain\investment\FixedInterestPercentageInvestment;
use \src\domain\investor\InvestorId;
use \src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use \src\domain\money\Money;
use \src\domain\percentage\format\DefaultPercent;
use \src\domain\percentage\Percentage;
use \Exception;

class FixedInterestPercentageInvestmentTest extends TestCase
{
    /**
     * @dataProvider successfulInterestDataProvider
     */
    public function testSuccessfulInterestCalculation(
        DateTime $investmentMadeAt,
        Percentage $rate,
        Money $amount,
        DateTime $start,
        DateTime $finish,
        Money $expectedInterest
    )
    {
        $this->assertEquals(
            $expectedInterest->amount(),
            (new FixedInterestPercentageInvestment(
                new InvestorId(1),
                $investmentMadeAt,
                $rate,
                $amount
            ))
                ->calculateFor($start, $finish)
                    ->amount()
        );
    }

    public function successfulInterestDataProvider()
    {
        return
            [
                [
                    new DateTime('2015-10-03'),
                    new DefaultPercent(3),
                    new InMinorUnits(100000, new Pound()),
                    new DateTime('2015-10-01'),
                    new DateTime('2015-10-31'),
                    new InMinorUnits(2806, new Pound())
                ],
                [
                    new DateTime('2015-10-01'),
                    new DefaultPercent(3),
                    new InMinorUnits(100000, new Pound()),
                    new DateTime('2015-10-01'),
                    new DateTime('2015-10-31'),
                    new InMinorUnits(3000, new Pound())
                ],
                [
                    new DateTime('2015-09-30'),
                    new DefaultPercent(3),
                    new InMinorUnits(100000, new Pound()),
                    new DateTime('2015-10-01'),
                    new DateTime('2015-10-31'),
                    new InMinorUnits(3000, new Pound())
                ],
            ];
    }

    /**
     * @dataProvider failedInterestDataProvider
     * @expectedException Exception
     */
    public function testFailedInterestCalculation(
        DateTime $investmentMadeAt,
        Percentage $rate,
        Money $amount,
        DateTime $start,
        DateTime $finish,
        Money $expectedInterest
    )
    {
        $this->assertEquals(
            $expectedInterest->amount(),
            (new FixedInterestPercentageInvestment(
                new InvestorId(1),
                $investmentMadeAt,
                $rate,
                $amount
            ))
                ->calculateFor($start, $finish)
                    ->amount()
        );
    }

    public function failedInterestDataProvider()
    {
        return
            [
                [
                    new DateTime('2015-12-01'),
                    new DefaultPercent(3),
                    new InMinorUnits(100000, new Pound()),
                    new DateTime('2015-10-01'),
                    new DateTime('2015-10-31'),
                    new InMinorUnits(2806, new Pound())
                ],
            ];
    }
}
