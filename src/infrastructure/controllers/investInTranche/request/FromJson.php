<?php

namespace src\infrastructure\controllers\investInTranche\request;

use src\useCases\Request;
use src\useCases\UseCase;
use \Closure;

class FromJson implements Action
{
    /**
     * @var UseCase
     */
    private $origin;

    /**
     * @var Closure
     */
    private $to;

    public function __construct(UseCase $origin, Closure /* (array) => Response */ $to)
    {
        $this->origin = $origin;
        $this->to = $to;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function act(Request $request)
    {
        return
            ($this->to)(
                $this->origin
                    ->act(
                        is_null($data = json_decode($request->body(), true))
                            ? []
                            : $data
                    )
            );
    }
}