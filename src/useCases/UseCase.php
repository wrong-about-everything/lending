<?php

namespace src\useCases;

use \Exception;

interface UseCase
{
    /**
     * @return array
     *
     * @throws Exception
     */
    public function act(Request $request);
}