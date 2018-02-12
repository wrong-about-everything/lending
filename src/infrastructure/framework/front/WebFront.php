<?php

namespace src\infrastructure\framework\front;

use src\useCases\Action;

class WebFront
{
    /**
     * @var Action
     */
    private $action;

    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    public function respond()
    {
        $this->action->act(new ReceivedHttpRequest())->display();
    }
}