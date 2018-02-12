<?php

namespace src\useCases;

interface Request
{
    /**
     * @return Method
     */
    public function method();

    /**
     * @return Uri
     */
    public function uri();

    /**
     * @return string[]
     */
    public function headers();

    /**
     * @return string
     */
    public function body();
}
