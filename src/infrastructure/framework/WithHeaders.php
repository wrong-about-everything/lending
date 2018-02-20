<?php

namespace src\infrastructure\framework;

use src\infrastructure\framework\http\response\Code;
use src\infrastructure\framework\http\response\Header;
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

    public function act(Request $request): Response
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

                protected function code(): Code
                {
                    return $this->origin->code();
                }

                protected function headers(): array
                {
                    return
                        array_merge(
                            $this->headers,
                            $this->origin->headers()
                        );
                }

                protected function body(): string
                {
                    return $this->origin->body();
                }
            };
    }
}
