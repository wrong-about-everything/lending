<?php

namespace test\domain\money\calculation;

use \PHPUnit\Framework\TestCase;
use \src\domain\money\calculation\Difference;
use \src\domain\money\currency\Pound;
use src\domain\money\currency\USDollar;
use \src\domain\money\format\InMinorUnits;
use \Exception;

class DifferenceTest extends TestCase
{
    /**
     * @dataProvider successfulDataProvider
     */
    public function testSuccessfulScenarios($expectedAmount, $left, $right)
    {
        $this->assertEquals(
            (new InMinorUnits($expectedAmount, new Pound()))
                ->amount(),
            (new Difference(
                new InMinorUnits($left, new Pound()),
                new InMinorUnits($right, new Pound())
            ))
                ->amount()
        );
    }

    public function successfulDataProvider()
    {
        return [
            [100, 1000, 900],
            [1, 2, 1],
            [0, 1, 1],
            [0, 1, 1],
        ];
    }

    /**
     * @dataProvider failedDataProvider
     * @expectedException Exception
     */
    public function testNegativeAmountScenarios($left, $right)
    {
        new Difference(
            new InMinorUnits($left, new Pound()),
            new InMinorUnits($right, new Pound())
        );
    }

    public function failedDataProvider()
    {
        return [
            [100, 900],
            [899, 900],
        ];
    }

    /**
     * @dataProvider failedDataProvider
     * @expectedException Exception
     */
    public function testDifferentCurrenciesScenarios($left, $right)
    {
        new Difference(
            new InMinorUnits($left, new USDollar()),
            new InMinorUnits($right, new Pound())
        );
    }
}
