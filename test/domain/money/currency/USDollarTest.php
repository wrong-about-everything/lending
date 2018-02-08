<?php

namespace test\domain\money\currency;

use PHPUnit\Framework\TestCase;
use src\domain\money\currency\USDollar;

class USDollarTest extends TestCase
{
    public function testCreation()
    {
        $this->assertEquals(
            'USD',
            (new USDollar())->isoCode()
        );
    }
}
