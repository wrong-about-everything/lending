<?php

namespace test\domain\percentage\format;

use PHPUnit\Framework\TestCase;
use src\domain\percentage\format\DefaultPercent;
use \Exception;

class DefaultPercentTest extends TestCase
{
    public function testSuccessfulCreation()
    {
        $this->assertEquals(
            0.9,
            (new DefaultPercent(90))->value()
        );
    }

    /**
     * @expectedException Exception
     */
    public function testFailedCreation()
    {
        new DefaultPercent(-7);
    }
}
