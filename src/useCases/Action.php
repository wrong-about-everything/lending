<?php

namespace src\useCases;

interface Action
{
    /**
     * @param Request $request
     * @return Response
     */
    public function act(Request $request): Response;
}
