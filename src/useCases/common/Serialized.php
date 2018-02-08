<?php

namespace src\useCases\common;

use src\useCases\Request;
use src\useCases\UseCase;
use \Exception;

class Serialized implements UseCase
{
    private $origin;
    private $lock;

    public function __construct(UseCase $origin, Lock $lock)
    {
        $this->origin = $origin;
        $this->lock = $lock;
    }

    public function act(Request $request)
    {
        $locked = $this->lock->lock();

        if (!$locked) {
            return ['code' => 'exception', 'Operation locked'];
        }

        try {
            $result = $this->origin->act($request);
        } catch (Exception $e) {
            $this->lock->unlock();
            throw $e;
        }

        $this->lock->unlock();

        return $result;
    }
}