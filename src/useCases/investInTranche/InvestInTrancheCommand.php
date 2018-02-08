<?php

namespace src\useCases\investInTranche;

use src\domain\investor\Investor;
use src\domain\money\Money;
use src\domain\tranche\Tranche;
use \Exception;

interface InvestInTrancheCommand
{
    /**
     * @return bool
     */
    public function isSuccessful();

    /**
     * @return array
     */
    public function errors();

    /**
     * @return Investor
     *
     * @throws Exception
     */
    public function investor();

    /**
     * @return Tranche
     *
     * @throws Exception
     */
    public function tranche();

    /**
     * @return Money
     *
     * @throws Exception
     */
    public function moneyToInvest();
}
