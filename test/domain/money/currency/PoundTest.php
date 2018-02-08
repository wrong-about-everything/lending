<?php

namespace test\domain\money\currency;

use PHPUnit\Framework\TestCase;
use src\domain\money\currency\Pound;

class PoundTest extends TestCase
{
    public function testCreation()
    {
        $this->assertEquals(
            'GBP',
            (new Pound())->isoCode()
        );
    }
}
