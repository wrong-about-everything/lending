<?php

namespace test\domain\money\format;

use PHPUnit\Framework\TestCase;
use src\domain\money\currency\Pound;
use src\domain\money\format\InMinorUnits;

class InMinorUnitsTest extends TestCase
{
    public function testCreation()
    {
        $inMinorUnits = new InMinorUnits(1000, new Pound());
        $this->assertEquals(1000, $inMinorUnits->amount());
        $this->assertEquals(new Pound(), $inMinorUnits->currency());
    }
}