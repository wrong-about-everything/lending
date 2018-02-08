<?php

namespace src\domain\money\calculation;

use \src\domain\money\Money;
use \Exception;

class Difference extends Money
{
    private $left;
    private $right;

    public function __construct(Money $left, Money $right)
    {
        if ($left->currency() != $right->currency()) {
            throw new Exception('Currencies must be the same.');
        }
        if ($left->amount() - $right->amount() < 0) {
            throw new Exception('The resulting amount is negative.');
        }

        $this->left = $left;
        $this->right = $right;
    }

    public function amount()
    {
        return $this->left->amount() - $this->right->amount();
    }

    public function currency()
    {
        return $this->left->currency();
    }
}
