<?php

namespace src\infrastructure\framework\http\response\header;

use src\infrastructure\framework\http\response\Header;
use \DateTime;

class DateHeader implements Header
{
    private $datetime;

    public function __construct(DateTime $datetime)
    {
        $this->datetime = $datetime;
    }

    public function value()
    {
        return 'Date: ' . $this->datetime->format('D, d M Y H:i:s') . ' GMT';
    }
}
