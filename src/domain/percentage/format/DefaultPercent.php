<?php

namespace src\domain\percentage\format;

use \Exception;
use src\domain\percentage\Percentage;

class DefaultPercent implements Percentage
{
    private $percent;

    public function __construct($percent)
    {
        if ($percent < 0) {
            throw new Exception('Percentage can not be negative');
        }

        $this->percent = $percent;
    }

    public function value()
    {
        return round($this->percent / 100, 4);
    }
}