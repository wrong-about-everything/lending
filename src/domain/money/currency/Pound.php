<?php

namespace src\domain\money\currency;

use src\domain\money\Currency;

class Pound implements Currency
{
    public function isoCode()
    {
        return 'GBP';
    }
}
