<?php

namespace src\useCases\common;

use \Exception;
use src\useCases\Request;
use src\useCases\UseCase;

class Fallback implements UseCase
{
    private $origin;

    public function __construct(UseCase $origin)
    {
        $this->origin = $origin;
    }

    public function act(Request $request)
    {
        try {
            return $this->origin->act($request);
        } catch (Exception $e) {
            return ['code' => 'exception', 'Something went wrong.'];
        }
    }
}