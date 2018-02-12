<?php

namespace src\useCases\investInTranche\request;

use src\useCases\Request;
use src\useCases\UseCase;

class FromJson implements Action
{
    /**
     * @var UseCase
     */
    private $origin;

    public function __construct(UseCase $origin)
    {
        $this->origin = $origin;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function act(Request $request)
    {
        return
            WithBodyAsArray(
                $this->origin
                    ->act(
                        is_null($data = json_decode($request->body(), true))
                            ? []
                            : $data
                    )
            );
    }
}