<?php

declare(strict_types=1);

namespace Hakone\Helper;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestClosureHandler implements RequestHandlerInterface
{
    /**
     * @phpstan-readonly-allow-private-mutation
     * @var ServerRequestInterface
     */
    public $received_request;

    /** @param Closure(ServerRequestInterface): ResponseInterface $callback */
    public function __construct(
        private Closure $callback
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->received_request = $request;

        return ($this->callback)($request);
    }
}
