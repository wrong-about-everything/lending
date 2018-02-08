<?php

namespace src\useCases\investInTranche\command;

use src\useCases\investInTranche\InvestInTrancheCommand;
use \Exception;

class InvalidInvestInTrancheCommand implements InvestInTrancheCommand
{
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function errors()
    {
        return array_merge(['code' => 'exception'], $this->errors);
    }

    public function investor()
    {
        throw new Exception('You operate upon an invalid command');
    }

    public function tranche()
    {
        throw new Exception('You operate upon an invalid command');
    }

    public function moneyToInvest()
    {
        throw new Exception('You operate upon an invalid command');
    }
}