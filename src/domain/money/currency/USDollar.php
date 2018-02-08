<?php

namespace src\domain\money\currency;

use src\domain\money\Currency;

class USDollar implements Currency
{
    public function isoCode()
    {
        return 'USD';
    }
}
