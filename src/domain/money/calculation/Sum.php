<?php

namespace src\domain\money\calculation;

use \Exception;
use src\domain\money\Money;

class Sum extends Money
{
    /**
     * @var Money
     */
    private $money1;

    /**
     * @var Money
     */
    private $money2;

    public function __construct(Money $money1, Money $money2)
    {
        if ($money1->currency() != $money2->currency()) {
            throw new Exception('Currencies must be the same.');
        }

        $this->money1 = $money1;
        $this->money2 = $money2;
    }

    public function amount()
    {
        return $this->money1->amount() + $this->money2->amount();
    }

    public function currency()
    {
        return $this->money1->currency();
    }
}
