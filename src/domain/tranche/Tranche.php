<?php

namespace src\domain\tranche;

use src\domain\loan\LoanId;
use \Exception;
use src\domain\money\Money;
use src\domain\percentage\Percentage;

interface Tranche
{
    /**
     * @return bool
     */
    public function exists();

    /**
     * @return TrancheId
     */
    public function id();

    /**
     * @return LoanId
     *
     * @throws Exception When non-existent tranche invoked.
     */
    public function loanId();

    /**
     * @return Money
     *
     * @throws Exception When non-existent tranche invoked.
     */
    public function currentInvestedAmount();

    /**
     * @return Percentage
     *
     * @throws Exception When non-existent tranche invoked.
     */
    public function percentage();

    /**
     * @param Money $money
     * @return bool
     *
     * @throws Exception When non-existent tranche invoked.
     */
    public function canAccept(Money $money);

    /**
     * @param Money $money
     * @return void
     *
     * @throws Exception When non-existent tranche invoked.
     */
    public function transfer(Money $money);
}