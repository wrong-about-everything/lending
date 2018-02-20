<?php

namespace src\infrastructure\framework\routing;

use src\infrastructure\framework\routing\ResourceNotFoundResponse;
use src\useCases\Action;
use src\useCases\Request;
use src\useCases\Response;

class RouteChain implements Action
{
    /**
     * @var Action[]
     */
    private $actions;

    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    public function act(Request $request): Response
    {
        foreach ($this->actions as $action) {
            $response = $action->act($request);

            if ($response->isResourceFound()) {
                return $response;
            }
        }

        return new ResourceNotFoundResponse();
    }
}
