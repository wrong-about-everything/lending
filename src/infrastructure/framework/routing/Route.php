<?php

namespace src\infrastructure\framework\routing;

use src\infrastructure\framework\http\request\HttpMethod;
use src\infrastructure\framework\routing\ResourceNotFoundResponse;
use src\useCases\Action;
use src\useCases\Request;

class Route implements Action
{
    private $location;
    private $method;
    private $action;

    public function __construct(ResourceLocation $location, HttpMethod $method, Action $action)
    {
        $this->location = $location;
        $this->method = $method;
        $this->action = $action;
    }

    public function act(Request $request)
    {
        if ($this->method->isEqualTo($request->method()) && $this->location->matches($request)) {
            return $this->action->act($request);
        }

        return new ResourceNotFoundResponse();
    }
}