<?php

namespace src\infrastructure\framework\fallback;

use src\useCases\Action;
use \Exception;
use src\useCases\Request;
use src\useCases\Response;

class Fallback implements Action
{
    private $action;
    private $response;

    public function __construct(Action $action, Response $response)
    {
        $this->action = $action;
        $this->response = $response;
    }

    public function act(Request $request): Response
    {
        try {
            return $this->action->act($request);
        } catch (Exception $e) {
            return $this->response;
        }
    }
}
