<?php

namespace src\infrastructure\framework\routing;

use src\useCases\Request;

class Route implements Action
{
    private $pattern;
    private $method;
    private $action;

    public function __construct(SearchPattern $pattern, Method $method, Action $action)
    {
        $this->pattern = $pattern;
        $this->method = $method;
        $this->action = $action;
    }

    public function act(Request $request)
    {
        if ($this->method->isEqualTo($request->method()) && $this->pattern->matches($request->url()->path())) {
            return $this->action->act($request);
        }

        return new ResourceNotFoundResponse();
    }
}