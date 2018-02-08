<?php

namespace test\domain\money\calculation;

use \PHPUnit\Framework\TestCase;
use \src\domain\money\calculation\Sum;
use \src\domain\money\currency\Pound;
use \src\domain\money\format\InMinorUnits;

class SumTest extends TestCase
{
    /**
     * @dataProvider successfulDataProvider
     */
    public function testSuccessfulScenarios($expectedAmount, $left, $right)
    {
        $this->assertEquals(
            (new InMinorUnits($expectedAmount, new Pound()))
                ->amount(),
            (new Sum(
                new InMinorUnits($left, new Pound()),
                new InMinorUnits($right, new Pound())
            ))
                ->amount()
        );
    }

    public function successfulDataProvider()
    {
        return [
            [99487, 689, 98798],
            [1000, 500, 500],
            [3, 2, 1],
            [2, 1, 1],
            [0, 0, 0],
            [1, 0, 1],
        ];
    }
}
