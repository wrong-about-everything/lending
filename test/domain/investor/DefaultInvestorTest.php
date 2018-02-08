<?php

namespace test\domain\investor;

use PHPUnit\Framework\TestCase;
use src\domain\investor\DefaultInvestor;
use src\domain\investor\InvestorId;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;
use src\domain\money\Money;

class DefaultInvestorTest extends TestCase
{
    /**
     * @dataProvider whetherAnInvestorHasEnoughMoneyDataProvider
     */
    public function testWhetherAnInvestorHasEnoughMoney(Money $walletAmount, Money $targetAmount, $hasEnough)
    {
        $this->assertEquals(
            $hasEnough,
            (new DefaultInvestor(
                new InvestorId(1),
                $walletAmount
            ))
                ->hasEnoughMoney($targetAmount)
        );
    }

    public function whetherAnInvestorHasEnoughMoneyDataProvider()
    {
        return
            [
                [new InMinorUnits(1000, new Pound()), new InMinorUnits(1000, new Pound()), true],
                [new InMinorUnits(1000, new Pound()), new InMinorUnits(999, new Pound()), true],
                [new InMinorUnits(1000, new Pound()), new InMinorUnits(500, new Pound()), true],
                [new InMinorUnits(1000, new Pound()), new InMinorUnits(1, new Pound()), true],
                [new InMinorUnits(1000, new Pound()), new InMinorUnits(1001, new Pound()), false],
                [new InMinorUnits(1000, new Pound()), new InMinorUnits(1500, new Pound()), false],
            ];
    }
}
