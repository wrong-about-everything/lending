<?php

namespace src\infrastructure\framework\http\response\header;

use src\useCases\Action;
use src\useCases\Request;
use src\useCases\Response;

class WithHeaders implements Action
{
    /**
     * @var Action
     */
    private $action;

    /**
     * @var Header[]
     */
    private $headers;

    public function __construct(Action $action, array $headers)
    {
        $this->action = $action;
        $this->headers = $headers;
    }

    public function act(Request $request)
    {
        return
            new class($this->action->act($request), $this->headers) extends Response
            {
                /**
                 * @var Response
                 */
                private $origin;

                private $headers;

                public function __construct(Response $origin, $headers)
                {
                    $this->origin = $origin;
                    $this->headers = $headers;
                }

                protected function code()
                {
                    return $this->origin->code();
                }

                protected function headers()
                {
                    return
                        array_merge(
                            $this->headers,
                            $this->origin->headers()
                        );
                }

                protected function body()
                {
                    return $this->origin->body();
                }
            };
    }
}
