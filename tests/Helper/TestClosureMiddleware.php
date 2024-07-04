<?php

declare(strict_types=1);

namespace Hakone\Helper;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestClosureMiddleware implements MiddlewareInterface
{
    private $callback;

    /**
     * @phpstan-readonly-allow-private-mutation
     * @var ServerRequestInterface
     */
    public $received_request;

    /** @param Closure(ServerRequestInterface, RequestHandlerInterface): ResponseInterface $callback */
    public function __construct(Closure $callback)
    {
        $this->callback = $callback;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $this->received_request = $request;

        return ($this->callback)($request, $handler);
    }
}
