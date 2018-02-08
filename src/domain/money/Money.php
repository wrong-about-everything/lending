<?php

namespace src\domain\money;

abstract class Money
{
    /**
     * @return int Amount in minor units.
     */
    abstract public function amount();

    /**
     * @return Currency
     */
    abstract public function currency();

    /**
     * @param Money $money
     * @return bool
     */
    public function isLessOrEqual(Money $money)
    {
        if ($this->currency() != $money->currency()) {
            throw new Exception('Currencies must be the same.');
        }

        return $this->amount() <= $money->amount();
    }
}
