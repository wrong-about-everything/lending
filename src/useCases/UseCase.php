<?php

namespace src\useCases;

use \Exception;

interface UseCase
{
    /**
     * @param $data array
     * @return array
     *
     * @throws Exception
     */
    public function act(array $data): array;
}