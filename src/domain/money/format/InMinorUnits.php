<?php

namespace src\domain\money\format;

use \Exception;
use src\domain\money\Currency;
use src\domain\money\Money;

class InMinorUnits extends Money
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var Currency
     */
    private $currency;

    public function __construct(/*int*/$amount, Currency $currency)
    {
        if (!ctype_digit((string) $amount) || $amount < 0) {
            throw new Exception('Invalid amount format.');
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function currency()
    {
        return $this->currency;
    }
}